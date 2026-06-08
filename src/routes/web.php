<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;

use App\Http\Controllers\KatalogUploadController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Barang;

// Home page
Route::get('/', function () {
    $barangs = Barang::where('status', 'tersedia')->get();
    $webReviews = \App\Models\WebReview::with('user')->latest()->take(12)->get();
    return view('index', compact('barangs', 'webReviews'));
})->name('home');

// Rentals page
Route::get('/rentals', function () {
    $query = Barang::with('kategori')->where('status', 'tersedia');
    if (Auth::check()) {
        $query->where('user_id', '!=', Auth::id());
    }
    $barangs = $query->get();
    $locations  = $barangs->map(function($b){ return $b->short_location; })->unique()->filter()->values()->toArray();
    $categories = Kategori::orderBy('nama_kategori')->pluck('nama_kategori')->toArray();
    return view('katalog.RentalsPage', compact('barangs', 'locations', 'categories'));
})->name('rentals');

// My Katalog – tampilkan barang milik user yang login (kosong jika guest)
Route::get('/katalog', function () {
    if (!Auth::check()) {
        $barangs = collect();
    } else {
        $barangs = Barang::with(['kategori', 'user'])->where('user_id', Auth::id())->get();
    }
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
    $product = Barang::with(['kategori', 'user', 'reviews.user'])->findOrFail($id);
    return view('katalog.ProductRentPage', compact('product'));
})->name('product');

// Real-time stock endpoint (public)
Route::get('/product/{id}/stok', function ($id) {
    $product = Barang::findOrFail($id);
    return response()->json([
        'stok'   => (int) $product->stok,
        'status' => $product->status,
    ]);
})->name('product.stok');

// Auth‑protected routes
Route::middleware('auth')->group(function () {
    // Profile dashboard pages
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/rentals', [\App\Http\Controllers\ProfileController::class, 'rentals'])->name('profile.rentals');
    Route::get('/profile/rentals/{id}', [\App\Http\Controllers\ProfileController::class, 'rentalDetail'])->name('profile.rentals.produk');
    Route::get('/profile/rentals/{id}/pengembalian', [\App\Http\Controllers\ProfileController::class, 'pengembalian'])->name('profile.rentals.pengembalian');
    Route::post('/profile/rentals/{id}/pengembalian', [\App\Http\Controllers\ProfileController::class, 'storePengembalian'])->name('profile.rentals.pengembalian.store');
    Route::get('/profile/rentals/{id}/confirmation', [\App\Http\Controllers\ProfileController::class, 'confirmation'])->name('profile.rentals.confirmation');
    Route::get('/profile/owner', [\App\Http\Controllers\ProfileController::class, 'owner'])->name('profile.owner');
    Route::get('/profile/owner/{id}', [\App\Http\Controllers\ProfileController::class, 'ownerDetail'])->name('profile.owner.produk');
    Route::post('/profile/owner/{id}/accept', [\App\Http\Controllers\ProfileController::class, 'acceptPengembalian'])->name('profile.owner.accept');
    Route::get('/profile/wallet', [\App\Http\Controllers\ProfileController::class, 'wallet'])->name('profile.wallet');

    // Ulasan tentang website SEWAIN
    Route::get('/review-web', [\App\Http\Controllers\WebReviewController::class, 'create'])->name('review-web');
    Route::post('/review-web', [\App\Http\Controllers\WebReviewController::class, 'store'])->name('review-web.store');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::patch('/cart/{id}/quantity', [CartController::class, 'updateQuantity']);

    // Add item routes (owner upload)
    Route::get('/katalog/add-item', [KatalogUploadController::class, 'create'])->name('katalog.add-item');
    Route::post('/katalog/add-item', [KatalogUploadController::class, 'store'])->name('katalog.add-item.post');

    // Checkout & Order — auth protected
    Route::get('/checkout/confirmation', [OrderController::class, 'confirmation'])->name('checkout.confirmation');
    Route::get('/checkout/{id?}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.post');
    Route::get('/order/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
});


// Edit item routes
Route::get('/katalog/edit-item/{id}', [KatalogUploadController::class, 'edit'])->name('katalog.edit-item');
Route::post('/katalog/edit-item/{id}', [KatalogUploadController::class, 'update'])->name('katalog.edit-item.post');
Route::delete('/katalog/delete-item/{id}', [KatalogUploadController::class, 'destroy'])->name('katalog.delete-item');

// ============================================================
// ADMIN ROUTES – hanya bisa diakses oleh user dengan role admin
// Data diambil dari database lewat AdminController.
// ============================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/financial-wallet', [\App\Http\Controllers\AdminController::class, 'financialWallet'])->name('financial-wallet');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'userDetail'])->name('users.detail');
    Route::post('/users/{id}/ban', [\App\Http\Controllers\AdminController::class, 'toggleBan'])->name('users.ban');
    Route::get('/items', [\App\Http\Controllers\AdminController::class, 'items'])->name('items');
    Route::get('/items/{id}', [\App\Http\Controllers\AdminController::class, 'itemDetail'])->name('items.detail');
    Route::get('/transactions', [\App\Http\Controllers\AdminController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{id}', [\App\Http\Controllers\AdminController::class, 'transactionDetail'])->name('transactions.detail');
});


