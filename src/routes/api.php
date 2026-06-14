<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\OwnerTransaksiController;
use App\Http\Controllers\Api\AdminController;

// Public Routes for Mobile App
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/google-login', [ApiAuthController::class, 'googleLogin']); // Endpoint untuk Google Login dari Android
Route::get('/katalog-publik', [App\Http\Controllers\Api\KatalogController::class, 'katalogPublik']);

// Protected Routes for Mobile App (Requires Sanctum Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });
    
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // API Profil Pengguna
    Route::get('/profile', [App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::post('/profile', [App\Http\Controllers\Api\ProfileController::class, 'update']);
    
    // CRUD API untuk Katalog Barang (Khusus User tersebut)
    Route::apiResource('katalog', App\Http\Controllers\Api\KatalogController::class);

    // API Keranjang Penyewaan
    Route::get('/keranjang', [KeranjangController::class, 'index']);
    Route::post('/keranjang/items', [KeranjangController::class, 'store']);
    Route::patch('/keranjang/items/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/items/{id}', [KeranjangController::class, 'destroy']);
    Route::delete('/keranjang', [KeranjangController::class, 'clear']);

    // API Transaksi & Pembayaran
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
    Route::post('/checkout', [TransaksiController::class, 'checkout']);
    Route::post('/transaksi/bayar', [TransaksiController::class, 'bayarMassal']);
    Route::post('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikanBarang']);

    // API Transaksi & Pembayaran (Owner)
    Route::get('/owner/dashboard', [OwnerTransaksiController::class, 'dashboard']);
    Route::get('/owner/transaksi/{id}', [OwnerTransaksiController::class, 'transaksiDetail']);
    Route::get('/owner/pengembalian', [OwnerTransaksiController::class, 'listPengembalian']);
    Route::post('/transaksi/{id}/verifikasi-pengembalian', [OwnerTransaksiController::class, 'verifikasiPengembalian']);

    // API Admin Dashboard & Management
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'listUsers']);
    Route::get('/admin/users/{id}', [AdminController::class, 'userDetail']);
    Route::post('/admin/users/{id}/toggle-ban', [AdminController::class, 'toggleBanUser']);
    Route::get('/admin/items', [AdminController::class, 'listItems']);
    Route::get('/admin/items/{id}', [AdminController::class, 'itemDetail']);
    Route::get('/admin/transactions', [AdminController::class, 'listTransactions']);
    Route::get('/admin/transactions/{id}', [AdminController::class, 'transactionDetail']);
    Route::get('/admin/finance', [AdminController::class, 'listPayments']);
    Route::get('/admin/finance/{id}', [AdminController::class, 'paymentDetail']);
});
