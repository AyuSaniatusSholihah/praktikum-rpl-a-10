<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\OrderReceiptMail;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\TransaksiPenyewaan;
use Illuminate\Support\Facades\Mail;

echo "Testing receipt email..." . PHP_EOL;

try {
    // Ambil data terakhir dari DB
    $pembayaran = Pembayaran::latest()->first();
    $order = Order::latest()->first();

    if (!$pembayaran || !$order) {
        echo "❌ Tidak ada data order/pembayaran di DB. Lakukan checkout dulu." . PHP_EOL;
        exit;
    }

    $transaksis = TransaksiPenyewaan::where('pembayaran_id', $pembayaran->id)
        ->with(['barang.user'])
        ->get();

    echo "Order ID: " . $order->id . PHP_EOL;
    echo "Pembayaran ID: " . $pembayaran->id . PHP_EOL;
    echo "Jumlah transaksi: " . $transaksis->count() . PHP_EOL;
    echo "Kirim ke: " . $order->email . PHP_EOL . PHP_EOL;

    Mail::to($order->email)->send(new OrderReceiptMail($order, $pembayaran, $transaksis));
    echo "✅ Receipt email berhasil dikirim ke " . $order->email . "!" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . PHP_EOL;
}
