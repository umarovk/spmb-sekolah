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
        // Alternatif menggunakan PHP untuk backup database
        try {
            // Ambil konfigurasi database dari env
            $dbConnection = Config::get('database.default');
            $dbConfig = Config::get('database.connections.' . $dbConnection);
            
            // Buat koneksi MySQL langsung
            $mysqli = new \mysqli(
                $dbConfig['host'],
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['database'],
                $dbConfig['port'] ?? 3306
            );
            
            // Cek koneksi
            if ($mysqli->connect_error) {
                throw new \Exception("Koneksi database gagal: " . $mysqli->connect_error);
            }
            
            // Mulai output buffering
            ob_start();
            
            // Header backup file
            echo "-- Database Backup for " . $dbConfig['database'] . "\n";
            echo "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
            
            // Dapatkan semua tabel
            $tables = [];
            $result = $mysqli->query("SHOW TABLES");
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            
            // Dump struktur dan data untuk setiap tabel
            foreach ($tables as $table) {
                // Struktur tabel
                echo "\n-- Struktur untuk tabel `$table`\n\n";
                echo "DROP TABLE IF EXISTS `$table`;\n";
                
                $res = $mysqli->query("SHOW CREATE TABLE `$table`");
                $row = $res->fetch_row();
                echo $row[1] . ";\n\n";
                
                // Data tabel
                echo "-- Data untuk tabel `$table`\n\n";
                
                $result = $mysqli->query("SELECT * FROM `$table`");
                $num_fields = $result->field_count;
                
                while ($row = $result->fetch_row()) {
                    echo "INSERT INTO `$table` VALUES (";
                    for ($i = 0; $i < $num_fields; $i++) {
                        if (isset($row[$i])) {
                            echo "'" . $mysqli->real_escape_string($row[$i]) . "'";
                        } else {
                            echo "NULL";
                        }
                        
                        if ($i < ($num_fields - 1)) {
                            echo ", ";
                        }
                    }
                    echo ");\n";
                }
                
                echo "\n";
            }
            
            $mysqli->close();
            
            // Ambil content dari buffer
            $content = ob_get_clean();
            
            // Set header untuk download
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "backup_" . $timestamp . ".sql";
            
            return response($content)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', "attachment; filename=$filename");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }

    public function generateBackupWithToken(Request $request)
    {
        // Check if token is provided and valid
        if (!$request->has('token') || $request->token !== 'umar') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or missing token'
            ], 401);
        }

        try {
            // Get database configuration
            $dbConnection = Config::get('database.default');
            $dbConfig = Config::get('database.connections.' . $dbConnection);
            
            // Create MySQL connection
            $mysqli = new \mysqli(
                $dbConfig['host'],
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['database'],
                $dbConfig['port'] ?? 3306
            );
            
            // Check connection
            if ($mysqli->connect_error) {
                throw new \Exception("Database connection failed: " . $mysqli->connect_error);
            }
            
            // Start output buffering
            ob_start();
            
            // Header backup file
            echo "-- Database Backup for " . $dbConfig['database'] . "\n";
            echo "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
            
            // Get all tables
            $tables = [];
            $result = $mysqli->query("SHOW TABLES");
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            
            // Dump structure and data for each table
            foreach ($tables as $table) {
                // Table structure
                echo "\n-- Structure for table `$table`\n\n";
                echo "DROP TABLE IF EXISTS `$table`;\n";
                
                $res = $mysqli->query("SHOW CREATE TABLE `$table`");
                $row = $res->fetch_row();
                echo $row[1] . ";\n\n";
                
                // Table data
                echo "-- Data for table `$table`\n\n";
                
                $result = $mysqli->query("SELECT * FROM `$table`");
                $num_fields = $result->field_count;
                
                while ($row = $result->fetch_row()) {
                    echo "INSERT INTO `$table` VALUES (";
                    for ($i = 0; $i < $num_fields; $i++) {
                        if (isset($row[$i])) {
                            echo "'" . $mysqli->real_escape_string($row[$i]) . "'";
                        } else {
                            echo "NULL";
                        }
                        
                        if ($i < ($num_fields - 1)) {
                            echo ", ";
                        }
                    }
                    echo ");\n";
                }
                
                echo "\n";
            }
            
            $mysqli->close();
            
            // Get content from buffer
            $content = ob_get_clean();
            
            // Create backup directory if it doesn't exist
            $storagePath = storage_path('app/backups');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            // Save backup file
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "backup_" . $timestamp . ".sql";
            $fullPath = $storagePath . '/' . $filename;
            
            file_put_contents($fullPath, $content);
            
            // Return file download response
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
}
