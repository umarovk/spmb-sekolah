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

# Panduan Deploy Laravel 10 di Ubuntu (PHP 8.1)

Dokumen ini dibuat sebagai panduan untuk deploy aplikasi Laravel dari awal di server Ubuntu. 
Panduan ini mengasumsikan bahwa kamu menggunakan Laravel versi 10 dengan PHP 8.1 dan server berbasis Ubuntu (20.04 atau lebih baru).

## Persyaratan Sistem

### Kebutuhan Server
- PHP 8.1 ✅
- Composer ✅
- MySQL ✅
- Apache ✅
- Git ✅

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

## Langkah-langkah Deploy

### 1. Update Ubuntu & Install Tools Dasar
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y software-properties-common unzip curl
```

### 2. Install PHP 8.1 dan Ekstensi Laravel
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.1 php8.1-cli php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl php8.1-mysql php8.1-zip php8.1-common php8.1-readline
```

### 3. Install Apache
```bash
sudo apt install -y apache2 libapache2-mod-php8.1
sudo systemctl enable apache2
sudo systemctl start apache2
```

### 4. Install MySQL
```bash
sudo apt install -y mysql-server
sudo systemctl enable mysql
sudo systemctl start mysql
```

> **Catatan Penting**: Setelah install MySQL, jalankan `sudo mysql_secure_installation` untuk mengatur password root dan keamanan dasar.

### 5. Install Composer
```bash
cd ~
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

> **Peringatan**: Jangan install Composer sebagai root user. Gunakan user biasa yang memiliki hak akses sudo.

### 6. Install Git
```bash
sudo apt install -y git
```

## Deploy Aplikasi Laravel

### 1. Clone Project Laravel
```bash
cd /var/www/html
sudo git clone [repository-url] spmb
cd spmb
```

### 2. Set File Permission
```bash
sudo chown -R www-data:www-data /var/www/html/spmb
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### 3. Install Dependency dengan Composer
```bash
composer install
```

### 4. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuai kebutuhan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password

APP_URL=http://your-domain-or-ip
SESSION_SECURE_COOKIE=false  # Set false jika tidak menggunakan HTTPS
```

### 5. Setup Database
```bash
mysql -u root -p
CREATE DATABASE nama_database;
```

### 6. Buat User Database
```bash
CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON nama_database.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
```

### 7. Migrasi Database
```bash
php artisan migrate
php artisan db:seed
```

### 8. Konfigurasi Virtual Host Apache
Buat file konfigurasi di `/etc/apache2/sites-available/spmb.conf`:
```apache
<VirtualHost *:80>
    ServerName your-domain
    DocumentRoot /var/www/html/spmb/public

    <Directory /var/www/html/spmb/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/spmb_error.log
    CustomLog ${APACHE_LOG_DIR}/spmb_access.log combined
</VirtualHost>
```

Aktifkan konfigurasi:
```bash
sudo a2ensite spmb
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## Troubleshooting

Jika mengalami masalah permission:
```bash
sudo chown -R www-data:www-data /var/www/html/spmb
sudo chmod -R 755 /var/www/html/spmb
```

## Keamanan

- Selalu gunakan password yang kuat untuk database
- Jangan simpan kredensial sensitif di file konfigurasi
- Aktifkan HTTPS untuk keamanan tambahan
- Batasi akses ke direktori sensitif
- Backup database secara berkala

## Catatan Penting

- Pastikan semua service (Apache, MySQL) berjalan dengan baik
- Periksa log error jika mengalami masalah
- Selalu backup data sebelum melakukan perubahan besar
- Update sistem secara berkala untuk keamanan

