<?php
// Script untuk melihat dan menghapus semua data transaksi lama

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use App\Models\Order;
use App\Models\Barang;
use App\Models\User;

echo "=== DATA SAAT INI ===" . PHP_EOL;
echo "Total User: " . User::count() . PHP_EOL;
echo "Total Barang: " . Barang::count() . PHP_EOL;
echo "Total Transaksi: " . TransaksiPenyewaan::count() . PHP_EOL;
echo "Total Pembayaran: " . Pembayaran::count() . PHP_EOL;
echo "Total Order: " . Order::count() . PHP_EOL . PHP_EOL;

echo "=== DAFTAR TRANSAKSI ===" . PHP_EOL;
TransaksiPenyewaan::with(['barang', 'pembayaran'])->latest()->get()->each(function($t) {
    $barang = $t->barang ? $t->barang->nama_barang : '-';
    echo "ID:{$t->id} | Barang: {$barang} | Status: {$t->status} | Tgl Sewa: {$t->tanggal_sewa} | Total: {$t->total_harga} | Dibuat: {$t->created_at}" . PHP_EOL;
});

echo PHP_EOL . "=== DAFTAR ORDER ===" . PHP_EOL;
Order::latest()->get()->each(function($o) {
    echo "ID:{$o->id} | Nama: {$o->first_name} {$o->last_name} | Email: {$o->email} | Dibuat: {$o->created_at}" . PHP_EOL;
});
