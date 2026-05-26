@echo off
REM Script untuk menjalankan Laravel Backend dan Vite Frontend otomatis
REM Harus dijalankan dari folder project

cd /d "%~dp0"

REM Jalankan PHP artisan serve (Backend) - hidden
start /B "" php artisan serve

REM Tunggu 2 detik
timeout /t 2 /nobreak

REM Jalankan npm run dev (Frontend) - hidden
start /B "" cmd /c npm run dev

REM Optional: Jika ingin lihat status, uncomment baris di bawah
REM echo Aplikasi sedang berjalan... php artisan serve dan npm run dev telah dimulai
