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
    Route::get('/profile/rentals/{id}/confirmation', [\App\Http\Controllers\ProfileController::class, 'confirmation'])->name('profile.rentals.confirmation');
    Route::get('/profile/owner', [\App\Http\Controllers\ProfileController::class, 'owner'])->name('profile.owner');
    Route::get('/profile/owner/{id}', [\App\Http\Controllers\ProfileController::class, 'ownerDetail'])->name('profile.owner.produk');
    Route::get('/profile/wallet', [\App\Http\Controllers\ProfileController::class, 'wallet'])->name('profile.wallet');

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
Route::get('/katalog/edit-item/{id}', [KatalogUploadController::class, 'edit'])->name('katalog.edit-item');
Route::post('/katalog/edit-item/{id}', [KatalogUploadController::class, 'update'])->name('katalog.edit-item.post');
Route::delete('/katalog/delete-item/{id}', [KatalogUploadController::class, 'destroy'])->name('katalog.delete-item');

// ============================================================
// ADMIN ROUTES – hanya bisa diakses oleh user dengan role admin
// ============================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Helper: pastikan user adalah admin, abort 403 jika bukan
    $onlyAdmin = function () {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
        }
    };

    // Dashboard
    Route::get('/', function () use ($onlyAdmin) {
        $onlyAdmin();
        return view('admin.dashboardPage');
    })->name('dashboard');

    // Financial Wallet
    Route::get('/financial-wallet', function () use ($onlyAdmin) {
        $onlyAdmin();
        return view('admin.financialWalletPage');
    })->name('financial-wallet');

    // Data Users (list)
    Route::get('/users', function () use ($onlyAdmin) {
        $onlyAdmin();
        return view('admin.dataUserPage');
    })->name('users');

    // Data User Detail
    Route::get('/users/{id}', function ($id) use ($onlyAdmin) {
        $onlyAdmin();
        $user = \App\Models\User::findOrFail($id);
        return view('admin.userDetailPage', compact('user'));
    })->name('users.detail');

    // Data Items (list)
    Route::get('/items', function () use ($onlyAdmin) {
        $onlyAdmin();
        return view('admin.dataItemPage');
    })->name('items');

    // Data Item Detail
    Route::get('/items/{id}', function ($id) use ($onlyAdmin) {
        $onlyAdmin();
        $item = \App\Models\Barang::with(['user', 'kategori', 'reviews.user'])->findOrFail($id);
        return view('admin.itemDetailPage', compact('item'));
    })->name('items.detail');

    // Data Transactions (list)
    Route::get('/transactions', function () use ($onlyAdmin) {
        $onlyAdmin();
        return view('admin.dataTransactions');
    })->name('transactions');

    // Data Transaction Detail
    Route::get('/transactions/{id}', function ($id) use ($onlyAdmin) {
        $onlyAdmin();
        $transaksi = \App\Models\TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran', 'review'])->findOrFail($id);
        return view('admin.transactionDetailPage', compact('transaksi'));
    })->name('transactions.detail');
});


