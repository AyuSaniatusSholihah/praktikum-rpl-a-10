<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\TransaksiController;

// Public Routes for Mobile App
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
Route::post('/login', [ApiAuthController::class, 'login']);
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
});
