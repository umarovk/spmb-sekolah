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
// Route::get('siswa/{id}/edit', [StudentController::class, 'edit'])->name('siswa.dataedit');



Route::resource('payments', PaymentController::class)->names([
    'index'   => 'payments.index',
    'create'  => 'payments.create',
    'store'   => 'payments.store',
    'show'    => 'payments.show',
    'edit'    => 'payments.edit',
    'update'  => 'payments.update',
    'destroy' => 'payments.destroy',
]);
// Route::get('payments/create/{siswa_id?}', [PaymentController::class, 'create'])->name('payments.create.with.siswa');
Route::get('payments/siswa/{siswa_id}', [PaymentController::class, 'bySiswa'])->name('payments.by.siswa');
Route::get('payments/siswa/{siswa_id}', [PaymentController::class, 'PaymentPerSiswa'])->name('PaymentPerSiswa');
// Route::get('/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');






// Route::get('/{id}/edit', [spmbcontroller::class, 'edit'])->name('documents.edit');




// Route::post('/', [spmbcontroller::class, 'store'])->name('documents.store');
// Route::put('/update/{id}', [spmbcontroller::class, 'update'])->name('documents.update');
// Route::delete('/hapus/{id}', [spmbcontroller::class, 'destroy'])->name('documents.destroy');

// Route::get('/siswa', [PembayaranController::class, 'tabelsiswa'])->name('documents.siswa');
// Route::get('/create', [spmbcontroller::class, 'createsiswa'])->name('documents.create');

// Route::get('/createbayars', [PembayaranController::class, 'createpembayarans'])->name('pembayarans.createbayar');
// Route::resource('pembayaran', PembayaranController::class);
// Route::get('pembayaran/siswa/{siswa_id}', [PembayaranController::class, 'getBySiswa'])->name('pembayaran.by.siswa');
// Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
// Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
// Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
// Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
// Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');










//claude AI
// Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
// Routes untuk Siswa
// Route tambahan untuk melihat pembayaran berdasarkan siswa
// Routes untuk Pembayaran
// Route::resource('pembayaran', PembayaranController::class);
// Route::get('/tabelpembayaran', [spmbcontroller::class, 'tabelpembayaran'])->name('tabelpembayaran');
// Route::post('/pembayaran', [PembayaranController::class, 'storepembayarans'])->name('pembayarans.store');
// Route::get('/pembayaran/tambah', [PembayaranController::class, 'create'])->name('pembayaran.create');
// Route::get('/', [HomeController::class, 'index']);
// Route::get('/create', [HomeController::class, 'create'])->name('siswa.create');
// Route::get('/siswa', [HomeController::class, 'siswa']);
// Route::resource('/siswa', HomeController::class);
// Route::post('/terima', [HomeController::class, 'terima'])->name('user.terima');


// Route::resource('/postsiswa', \App\Http\Controllers\spmbcontroller::class);
// Route::get('/siswa', [spmbcontroller::class, 'tabelsiswa'])->name('documents.siswa');
// Route::get('/index2', [HomeController::class, 'index2']);

// Route::get('/', [HomeController::class, 'index']);
//rute-dapatkan (get) pada directory index (/), tampilkanlah file HomeController yang berisi class, yang isinya function 'index'