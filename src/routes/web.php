<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify.post');

Route::get('/dashboard', function () {
    return "<h1>Dashboard</h1><p>Welcome, " . auth()->user()->name . "!</p><a href='/logout'>Logout</a>";
})->middleware('auth')->name('dashboard');

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

Route::get('/auth/redirect', [SocialiteController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('auth.callback');
