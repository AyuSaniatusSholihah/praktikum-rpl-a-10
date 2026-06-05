<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\KatalogUploadController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Barang;

// Home page
Route::get('/', function () {
    $barangs = Barang::where('status', 'tersedia')->get();
    return view('index', compact('barangs'));
})->name('home');

// Rentals page
Route::get('/rentals', function () {
    $barangs   = Barang::with('kategori')->where('status', 'tersedia')->get();
    $locations = $barangs->pluck('lokasi')->unique()->filter()->values()->toArray();
    $categories = $barangs->map(fn($b) => $b->kategori->nama_kategori ?? null)
                          ->unique()->filter()->values()->toArray();
    return view('katalog.RentalsPage', compact('barangs', 'locations', 'categories'));
})->name('rentals');

// My Katalog – tampilkan barang milik user yang login (atau semua jika guest)
Route::get('/katalog', function () {
    $query = Barang::with(['kategori', 'user']);
    if (Auth::check()) {
        $query->where('user_id', Auth::id());
    }
    $barangs = $query->get();
    return view('katalog.MyKatalog', compact('barangs'));
})->name('katalog');
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    return "<h1>Dashboard</h1><p>Welcome, {$user->name}!</p>".
        "<form action='" . route('logout') . "' method='POST'>".
        csrf_field()."<button type='submit'>Logout</button></form>";
})->middleware('auth')->name('dashboard');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Optional GET logout for convenience
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify.post');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.email');
Route::get('/reset-password-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
Route::post('/reset-password-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Socialite routes
Route::get('/auth/redirect', [SocialiteController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('auth.callback');

// Product detail page
Route::get('/product/{id}', function ($id) {
    $product = Barang::with(['kategori', 'user'])->findOrFail($id);
    return view('katalog.ProductRentPage', compact('product'));
})->name('product');

// Auth‑protected routes
Route::middleware('auth')->group(function () {
    // Profile dashboard pages
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/rentals', fn () => view('profile.MyRentalsPage', ['user' => Auth::user()]))->name('profile.rentals');
    Route::get('/profile/rentals/produk', fn () => view('profile.MyRentalsProdukPage', ['user' => Auth::user()]))->name('profile.rentals.produk');
    Route::get('/profile/rentals/pengembalian', fn () => view('profile.MyRentalsPengembalianPage', ['user' => Auth::user()]))->name('profile.rentals.pengembalian');
    Route::get('/profile/rentals/confirmation', fn () => view('profile.MyRentalsConfirmationPage', ['user' => Auth::user()]))->name('profile.rentals.confirmation');
    Route::get('/profile/owner', fn () => view('profile.MyRentalsOwnerPage', ['user' => Auth::user()]))->name('profile.owner');
    Route::get('/profile/owner/produk', fn () => view('profile.MyRentalsOwnerProdukPage', ['user' => Auth::user()]))->name('profile.owner.produk');
    Route::get('/profile/wallet', fn () => view('profile.MyWalletPage', ['user' => Auth::user()]))->name('profile.wallet');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::patch('/cart/{id}/quantity', [CartController::class, 'updateQuantity']);

    // Checkout
    // PENTING: Route spesifik harus SEBELUM route dengan parameter wildcard
    Route::get('/checkout/confirmation', [OrderController::class, 'confirmation'])->name('checkout.confirmation');
    Route::get('/checkout/{id?}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.post');

    // Add item routes (owner upload)
    Route::get('/katalog/add-item', [KatalogUploadController::class, 'create'])->name('katalog.add-item');
    Route::post('/katalog/add-item', [KatalogUploadController::class, 'store'])->name('katalog.add-item.post');

    // Order confirmation
    Route::get('/order/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
});

// Edit item routes
// Edit item route with product ID
Route::get('/katalog/edit-item/{id}', function ($id) {
    $product = Barang::findOrFail($id);
    return view('katalog.EditItemPage', compact('product'));
})->name('katalog.edit-item');
?>
