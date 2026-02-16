<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TranscriptController;

// --- RUTE PUBLIK ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// --- RUTE TERPROTEKSI (Wajib Login) ---
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transkrip', [TranscriptController::class, 'index'])->name('transkrip.index');
    
    // Rute Pelanggan
    Route::get('/pelanggan', [CustomerController::class, 'index'])->name('pelanggan.index');
    Route::post('/pelanggan', [CustomerController::class, 'store'])->name('pelanggan.store');
    Route::put('/pelanggan/{id}', [CustomerController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [CustomerController::class, 'destroy'])->name('pelanggan.destroy');

    // Rute Pembayaran
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/get-customer/{id}', [PaymentController::class, 'getCustomer']);
    Route::post('/pembayaran', [PaymentController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/cetak/{id}', [PaymentController::class, 'downloadStruk'])->name('pembayaran.cetak');
    Route::delete('/pembayaran/{id}', [PaymentController::class, 'destroy'])->name('pembayaran.destroy');
    Route::post('/pembayaran/import', [PaymentController::class, 'import'])->name('pembayaran.import');
});
