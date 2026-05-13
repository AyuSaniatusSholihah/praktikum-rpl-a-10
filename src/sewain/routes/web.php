<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/auth/google', [App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\SocialiteController::class, 'callback']);
Route::get('/auth/email', [App\Http\Controllers\AuthController::class, 'redirectEmail'])->name('auth.email');
Route::get('/terms', [App\Http\Controllers\PageController::class, 'terms'])->name('terms');


require __DIR__ . '/auth.php';
