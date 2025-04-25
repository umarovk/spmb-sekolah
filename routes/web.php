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
// Route::get('/{id}/ubah', [StudentController::class, 'ubah'])->name('siswa.ubah'); //INI WORK

Route::resource('payments', PaymentController::class)->names([
    'index'   => 'payments.index',
    'create'  => 'payments.create',
    'store'   => 'payments.store',
    'show'    => 'payments.show',
    'edit'    => 'paymentsaa.edit',
    'update'  => 'payments.update',
    'destroy' => 'payments.destroy',
]);
Route::get('/tabelbayar', [PaymentController::class, 'tabelbayar'])->name('tabelbayar');
Route::get('/paymentsdetailsiswa', [PaymentController::class, 'paymentsdetailsiswa'])->name('payments.detailsiswa');
// Route::get('payments/create/{siswa_id?}', [PaymentController::class, 'create'])->name('payments.create.with.siswa');
// Route::get('payments/siswa/{siswa_id}', [PaymentController::class, 'bySiswa'])->name('payments.by.siswa');

// Route::get('/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');