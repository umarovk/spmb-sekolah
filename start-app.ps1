# Script untuk menjalankan Laravel Backend dan Vite Frontend otomatis
# Pastikan PowerShell execution policy memungkinkan script ini untuk dijalankan

$projectPath = Split-Path -Parent $MyInvocation.MyCommand.Path

# Jalankan PHP artisan serve (Backend)
Start-Process -WindowStyle Hidden -WorkingDirectory $projectPath -FilePath "php" -ArgumentList "artisan serve" -NoNewWindow

# Tunggu 2 detik sebelum start frontend
Start-Sleep -Seconds 2

# Jalankan npm run dev (Frontend)
Start-Process -WindowStyle Hidden -WorkingDirectory $projectPath -FilePath "cmd" -ArgumentList "/c npm run dev" -NoNewWindow

Write-Host "✓ Backend (php artisan serve) dimulai"
Write-Host "✓ Frontend (npm run dev) dimulai"
Write-Host "Aplikasi spmb-sekolah sedang berjalan..."
