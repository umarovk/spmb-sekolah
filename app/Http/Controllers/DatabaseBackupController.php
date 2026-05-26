<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        // Tampilkan halaman backup database
        return view('admin.backup.index');
    }

    public function generateBackup()
    {
        // Ambil konfigurasi database dari env
        $dbConnection = Config::get('database.default');
        $dbConfig = Config::get('database.connections.' . $dbConnection);
        
        $timestamp = \Carbon\Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "backup_" . $timestamp . ".sql";
        $storagePath = storage_path('app/backups');
        
        // Pastikan direktori backup ada
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        $fullPath = $storagePath . '/' . $filename;
        
        // Command untuk mysqldump
        $command = sprintf(
            'mysqldump -h %s -u %s %s %s > %s',
            escapeshellarg($dbConfig['host']),
            escapeshellarg($dbConfig['username']),
            !empty($dbConfig['password']) ? '-p' . escapeshellarg($dbConfig['password']) : '',
            escapeshellarg($dbConfig['database']),
            escapeshellarg($fullPath)
        );
        
        // Jalankan proses mysqldump
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600); // Set timeout 1 jam untuk database besar
        
        try {
            $process->mustRun();
            
            // Kembalikan file untuk didownload
            return response()->download($fullPath)->deleteFileAfterSend(true);
        } catch (ProcessFailedException $exception) {
            return redirect()->back()->with('error', 'Gagal membuat backup database: ' . $exception->getMessage());
        }
    }
    
    public function downloadBackupUsingPHP()
    {
        try {
            $dbConfig = Config::get('database.connections.' . Config::get('database.default'));
            $content = $this->buildSqlDump($dbConfig);

            $filename = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

            return response($content)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', "attachment; filename=$filename");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }

    public function generateBackupWithToken(Request $request)
    {
        if (!$request->has('token') || $request->token !== 'umar') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or missing token'
            ], 401);
        }

        try {
            $dbConfig = Config::get('database.connections.' . Config::get('database.default'));
            $content = $this->buildSqlDump($dbConfig);

            $storagePath = storage_path('app/backups');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $filename = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            $fullPath = $storagePath . '/' . $filename;
            file_put_contents($fullPath, $content);

            return response()->download($fullPath, $filename, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate backup: ' . $e->getMessage()
            ], 500);
        }
    }

    private function buildSqlDump(array $dbConfig): string
    {
        $mysqli = new \mysqli(
            $dbConfig['host'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['database'],
            $dbConfig['port'] ?? 3306
        );

        if ($mysqli->connect_error) {
            throw new \Exception('Koneksi database gagal: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');

        ob_start();
        try {
            echo "-- Database Backup for " . $dbConfig['database'] . "\n";
            echo "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
            echo "SET NAMES utf8mb4;\n";
            echo "SET FOREIGN_KEY_CHECKS=0;\n";
            echo "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n";

            $tables = [];
            $result = $mysqli->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }

            foreach ($tables as $table) {
                echo "\n-- Struktur untuk tabel `$table`\n\n";
                echo "DROP TABLE IF EXISTS `$table`;\n";

                $res = $mysqli->query("SHOW CREATE TABLE `$table`");
                $row = $res->fetch_row();
                echo $row[1] . ";\n\n";

                echo "-- Data untuk tabel `$table`\n\n";

                $result = $mysqli->query("SELECT * FROM `$table`");
                $numFields = $result->field_count;

                while ($row = $result->fetch_row()) {
                    echo "INSERT INTO `$table` VALUES (";
                    for ($i = 0; $i < $numFields; $i++) {
                        if (isset($row[$i])) {
                            echo "'" . $mysqli->real_escape_string($row[$i]) . "'";
                        } else {
                            echo "NULL";
                        }
                        if ($i < ($numFields - 1)) {
                            echo ", ";
                        }
                    }
                    echo ");\n";
                }
                echo "\n";
            }

            echo "\nSET FOREIGN_KEY_CHECKS=1;\n";

            return ob_get_clean();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        } finally {
            $mysqli->close();
        }
    }

    public function downloadBackup($filename)
    {
        $file = storage_path('app/backups/' . $filename);

        if (!file_exists($file)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Backup file not found'
            ], 404);
        }

        return response()->download($file)->deleteFileAfterSend(true);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:102400',
            'konfirmasi'  => 'accepted',
        ], [
            'backup_file.required' => 'File backup wajib diunggah.',
            'backup_file.file'     => 'File tidak valid.',
            'backup_file.max'      => 'Ukuran file maksimal 100 MB.',
            'konfirmasi.accepted'  => 'Anda harus mencentang konfirmasi sebelum restore.',
        ]);

        $upload = $request->file('backup_file');
        $extension = strtolower($upload->getClientOriginalExtension());
        if (!in_array($extension, ['sql', 'txt'], true)) {
            return redirect()->back()->with('error', 'Ekstensi file harus .sql atau .txt');
        }

        $storagePath = storage_path('app/backups/restore');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $savedName = "restore_{$timestamp}.sql";
        $fullPath = $storagePath . DIRECTORY_SEPARATOR . $savedName;
        $upload->move($storagePath, $savedName);

        $dbConnection = Config::get('database.default');
        $dbConfig = Config::get('database.connections.' . $dbConnection);

        try {
            $this->restoreWithMysqlCli($dbConfig, $fullPath);
        } catch (\Throwable $cliError) {
            try {
                $this->restoreWithPhp($dbConfig, $fullPath);
            } catch (\Throwable $phpError) {
                @unlink($fullPath);
                return redirect()->back()->with(
                    'error',
                    'Gagal restore database. mysql CLI: ' . $cliError->getMessage()
                        . ' | PHP fallback: ' . $phpError->getMessage()
                );
            }
        }

        @unlink($fullPath);

        return redirect()->route('admin.backup.index')
            ->with('success', 'Database berhasil di-restore dari file: ' . $upload->getClientOriginalName());
    }

    private function restoreWithMysqlCli(array $dbConfig, string $filePath): void
    {
        $command = sprintf(
            'mysql -h %s -u %s %s %s < %s',
            escapeshellarg($dbConfig['host']),
            escapeshellarg($dbConfig['username']),
            !empty($dbConfig['password']) ? '-p' . escapeshellarg($dbConfig['password']) : '',
            escapeshellarg($dbConfig['database']),
            escapeshellarg($filePath)
        );

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600);
        $process->mustRun();
    }

    private function restoreWithPhp(array $dbConfig, string $filePath): void
    {
        $mysqli = new \mysqli(
            $dbConfig['host'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['database'],
            $dbConfig['port'] ?? 3306
        );

        if ($mysqli->connect_error) {
            throw new \Exception('Koneksi database gagal: ' . $mysqli->connect_error);
        }

        $mysqli->query('SET FOREIGN_KEY_CHECKS = 0');

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $mysqli->close();
            throw new \Exception('Tidak dapat membuka file backup.');
        }

        $statement = '';
        $inString = false;
        $stringChar = '';

        try {
            while (($line = fgets($handle)) !== false) {
                $trimmed = ltrim($line);
                if ($statement === '' && ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '#') || str_starts_with($trimmed, '/*'))) {
                    continue;
                }

                $statement .= $line;
                $len = strlen($line);
                for ($i = 0; $i < $len; $i++) {
                    $ch = $line[$i];
                    $prev = $i > 0 ? $line[$i - 1] : '';
                    if ($inString) {
                        if ($ch === $stringChar && $prev !== '\\') {
                            $inString = false;
                        }
                    } else {
                        if ($ch === "'" || $ch === '"') {
                            $inString = true;
                            $stringChar = $ch;
                        } elseif ($ch === ';') {
                            $sql = trim($statement);
                            if ($sql !== '' && $sql !== ';') {
                                if (!$mysqli->query(rtrim($sql, ';'))) {
                                    throw new \Exception('Query gagal: ' . $mysqli->error);
                                }
                            }
                            $statement = '';
                        }
                    }
                }
            }

            $tail = trim($statement);
            if ($tail !== '') {
                if (!$mysqli->query(rtrim($tail, ';'))) {
                    throw new \Exception('Query gagal: ' . $mysqli->error);
                }
            }
        } finally {
            fclose($handle);
            $mysqli->query('SET FOREIGN_KEY_CHECKS = 1');
            $mysqli->close();
        }
    }
}
