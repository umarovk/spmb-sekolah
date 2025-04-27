<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\spmbcontroller;
use App\Http\Controllers\PembayaranController;
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [StudentController::class, 'index'])->name('siswa.index');

Route::resource('siswa', StudentController::class)->names([
    'index'   => 'siswa.index',
    'create'  => 'siswa.create',
    'store'   => 'siswa.store',
    'show'    => 'siswa.show',
    'edit'    => 'siswa.edit',
    'update'  => 'siswa.update',
    'destroy' => 'siswa.destroy',
]);
Route::get('/tabelsiswa', [StudentController::class, 'tabelsiswa'])->name('tabelsiswa');
Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('siswa.editdata');
Route::get('/siswa/{siswa}/print/surat-keterangan', [StudentController::class, 'printSuratKeterangan'])
    ->name('siswa.print.surat-keterangan');
// Route::get('/{id}/ubah', [StudentController::class, 'ubah'])->name('siswa.ubah'); //INI WORK

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
Route::get('/paymentsdetailsiswa/{$siswa_id}', [PaymentController::class, 'paymentsdetailsiswa'])->name('paymentsdetailsiswa');

// Route::get('/payments/create/{siswa_id}', [PaymentController::class, 'create'])->name('payments.create');
Route::get('/payments/detail/{siswa_id}', [PaymentController::class, 'detail'])->name('payments.detail');
Route::get('/test', [StudentController::class, 'test'])->name('test');

// ...existing routes...
Route::get('/payments/{payment}/print/kwitansi', [PaymentController::class, 'printKwitansi'])
    ->name('payments.print.kwitansi');
Route::get('/payments/{payment}/print/pdf', [PaymentController::class, 'printPdf'])
    ->name('payments.print.pdf');