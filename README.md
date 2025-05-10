# SPMB Sekolah - Sistem Penerimaan Murid Baru

Sistem Penerimaan Murid Baru (SPMB) adalah aplikasi web yang dikembangkan spesial request untuk SMK Cokroaminoto Wanadadi menggunakan Laravel v10 untuk mengelola proses penerimaan siswa baru di sekolah. Aplikasi ini menyediakan fitur-fitur untuk manajemen data siswa, pembayaran, dan proses seleksi.

## Persyaratan Sistem

### Software Requirements
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- git

### Ekstensi PHP yang Diperlukan
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Instalasi

1. Clone repository ini:
```bash
git clone [repository-url]
cd spmb-sekolah
```

2. Install dependencies PHP:
```bash
composer install
```

3. Install dependencies Node.js:
```bash
npm install
```

4. Salin file .env.example menjadi .env:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Konfigurasi database di file .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spmb_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi database:
```bash
php artisan migrate
```

8. Jalankan seeder untuk data awal:
```bash
php artisan db:seed
```

9. Compile assets:
```bash
npm run dev
```

10. Jalankan server development:
```bash
php artisan serve

untuk lebih detail bagaimana cara deploy Laravel10 di VPS Linux, sila kunjungi link berikut:
https://github.com/umarovk/deploy-laravel.git
```

## Fitur-fitur Aplikasi

### 1. Manajemen Siswa (CRUD)
- Pendaftaran siswa baru
- Pengelolaan data siswa
- Cetak surat keterangan
- Cetak surat diterima
- Export data siswa ke Excel

### 2. Manajemen Pembayaran (CRUD)
- Pencatatan pembayaran
- Cetak kwitansi
- Cetak PDF pembayaran
- Export data pembayaran ke Excel
- Detail pembayaran per siswa

### 3. Proses Seleksi
- Pengelolaan status seleksi siswa
- Update status seleksi
- Monitoring proses seleksi

### 4. Backup Database
- Generate backup database
- Download backup database
- API endpoint untuk backup otomatis
- Script auto backup untuk CLI (Terminal/CMD/Termux)

## Role Pengguna

Aplikasi memiliki beberapa role pengguna dengan hak akses yang berbeda:

1. **Admin**
   - Akses penuh ke semua fitur
   - Manajemen pengguna
   - Backup database
   - CRUD data siswa
   - CRUD data pembayaran
   - Update hasil seleksi

2. **Teller**
   - Input data siswa 
   - Input data pembayaran (tanpa update/delete)
   - Cetak kwitansi
   - Lihat data siswa

3. **Selektor**
   - Input data siswa 
   - Input hasil ujian seleksi
   - Lihat data siswa

4. **Guest**
   - Input data siswa baru
   - Akses terbatas

## Endpoint API

### Backup Database
- GET `/admin/backup` - Halaman backup database
- GET `/admin/backup/generate` - Generate backup database
- GET `/admin/backup/generate-php` - Download backup menggunakan PHP
- GET `/api/backup/generate?token={token}` - API endpoint untuk backup otomatis

### Auto Backup Script
Untuk mengatur backup otomatis, Anda dapat menggunakan script CLI yang tersedia di:
```
https://github.com/eexvuu/spmb-auto-backup.git
```

Script ini dapat dijalankan melalui:
- Terminal Linux/Mac
- Command Prompt Windows
- Termux (Android)

