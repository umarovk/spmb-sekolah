<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--filename= : Custom filename for backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database to SQL file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup database...');

        // Ambil konfigurasi database dari env
        $dbConnection = Config::get('database.default');
        $dbConfig = Config::get('database.connections.' . $dbConnection);
        
        // Buat nama file dengan timestamp
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = $this->option('filename') ?: "backup_" . $timestamp . ".sql";
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
            $this->info('Backup database berhasil dibuat di: ' . $fullPath);
            return 0;
        } catch (ProcessFailedException $exception) {
            $this->error('Backup database gagal: ' . $exception->getMessage());
            return 1;
        }
    }
}