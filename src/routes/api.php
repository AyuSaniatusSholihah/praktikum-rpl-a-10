<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiAuthController;

// Public Routes for Mobile App
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
Route::post('/login', [ApiAuthController::class, 'login']);

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
});
