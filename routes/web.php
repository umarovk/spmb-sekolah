<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\spmbcontroller;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\UserController;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Add GET route for logout that redirects to POST route
Route::get('/logout', function() {
    return redirect()->route('home');
})->name('logout.get');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Routes accessible by all authenticated users
    Route::get('/', [StudentController::class, 'index'])->name('home');

    // Guest & Admin Routes (Student Management)
    Route::middleware(['role:guest,admin,teller,selektor'])->group(function () {
        Route::resource('siswa', StudentController::class)->names([
            'index'   => 'siswa.index',
            'create'  => 'siswa.create',
            'store'   => 'siswa.store',
            'show'    => 'siswa.show',
            'update'  => 'siswa.update',
            'destroy' => 'siswa.destroy',
        ]);
        Route::get('/tabelsiswa', [StudentController::class, 'tabelsiswa'])->name('tabelsiswa');
        Route::get('/{id}/editsiswa', [StudentController::class, 'ubah'])->name('siswa.ubah');
        Route::get('/siswa/{siswa}/print/surat-keterangan', [StudentController::class, 'printSuratKeterangan'])
            ->name('siswa.print.surat-keterangan');
        Route::get('/siswa/{siswa}/print/surat-diterima', [StudentController::class, 'printSuratDiterima'])
            ->name('siswa.print.surat-diterima');
        Route::get('/export-siswa', [StudentController::class, 'export'])->name('siswa.export');
        Route::get('/rangkuman', [StudentController::class, 'rangkuman'])->name('siswa.rangkuman');
    });

    // Teller & Admin Routes (Payment Management)
    Route::middleware(['role:teller,admin'])->group(function () {
        Route::resource('payments', PaymentController::class)->names([
            'index'   => 'payments.index',
            'create'  => 'payments.create',
            'store'   => 'payments.store',
            'show'    => 'payments.show',
            'edit'    => 'payments.edit',
            'update'  => 'payments.update',
            'destroy' => 'payments.destroy',
        ]);
        Route::get('/tabelbayar', [PaymentController::class, 'tabelbayar'])->name('tabelbayar');
        Route::get('/payments/detail/{siswa_id}', [PaymentController::class, 'detail'])->name('payments.detail');
        Route::get('/payments/{payment}/print/kwitansi', [PaymentController::class, 'printKwitansi'])
            ->name('payments.print.kwitansi');
        Route::get('/payments/{payment}/print/pdf', [PaymentController::class, 'printPdf'])
            ->name('payments.print.pdf');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
        Route::get('/export-payments', [PaymentController::class, 'export'])
            ->name('payments.export')
            ->middleware(['auth', 'role:admin,teller']);

        Route::get('/export-payments2', [PaymentController::class, 'export2'])
            ->name('payments.export2')
            ->middleware(['auth', 'role:admin,teller']);
    });

    
    // Routes untuk backup database
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/backup', [App\Http\Controllers\DatabaseBackupController::class, 'index'])->name('admin.backup.index');
        Route::get('/admin/backup/generate', [App\Http\Controllers\DatabaseBackupController::class, 'generateBackup'])->name('admin.backup.generate');
        Route::get('/admin/backup/generate-php', [App\Http\Controllers\DatabaseBackupController::class, 'downloadBackupUsingPHP'])->name('admin.backup.generate-php');
        Route::post('/admin/backup/restore', [App\Http\Controllers\DatabaseBackupController::class, 'restore'])->name('admin.backup.restore');

        // App Settings (Google Sheets dll)
        Route::get('/admin/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/settings/test-sheets', [App\Http\Controllers\SettingsController::class, 'testSheets'])->name('admin.settings.test-sheets');
    });
    
    // Selection routes
    Route::middleware(['auth', 'role:selektor,admin'])->group(function () {
        Route::get('/seleksi', [SeleksiController::class, 'index'])->name('seleksi.index');
        Route::post('/seleksi/{id}/update-status', [SeleksiController::class, 'updateStatus'])
            ->name('seleksi.update-status');
        Route::get('/seleksi-export', [SeleksiController::class, 'export'])->name('seleksi.export');
        Route::get('/seleksi/{id}/jawaban', [SeleksiController::class, 'jawaban'])->name('seleksi.jawaban');
    });


    // pengambilan bahan routes
    Route::middleware(['auth', 'role:selektor,admin'])->group(function () {
        Route::resource('bahan', BahanController::class);
        Route::get('/bahan-export', [BahanController::class, 'export'])->name('bahan.export');
        Route::get('/{bahan}/ubah', [BahanController::class, 'ubah'])->name('bahan.ubah');
    });

    // User Management Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

