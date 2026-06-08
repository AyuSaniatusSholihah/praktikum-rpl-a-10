<?php
// Script untuk hapus data transaksi lama (ID 1 dan 2) + rollback stok + rollback saldo owner

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use App\Models\Order;
use App\Models\User;

// ID yang akan dihapus (ID 1 dan 2)
$idsToDelete = [1, 2];

foreach ($idsToDelete as $id) {
    $trx = TransaksiPenyewaan::with(['barang', 'pembayaran'])->find($id);
    if (!$trx) {
        echo "Transaksi ID:{$id} tidak ditemukan, skip." . PHP_EOL;
        continue;
    }

    echo "Memproses Transaksi ID:{$id} | Barang: " . ($trx->barang->nama_barang ?? '-') . " | Status: {$trx->status}" . PHP_EOL;

    // 1. Kembalikan stok barang
    if ($trx->barang) {
        $trx->barang->stok += $trx->jumlah;
        // Kembalikan status jika sebelumnya tidak_tersedia
        if ($trx->barang->status === 'tidak_tersedia' && $trx->barang->stok > 0) {
            $trx->barang->status = 'tersedia';
        }
        $trx->barang->save();
        echo "  → Stok barang dikembalikan: +{$trx->jumlah} (stok sekarang: {$trx->barang->stok})" . PHP_EOL;
    }

    // 2. Hapus pembayaran terkait
    $pembayaranId = $trx->pembayaran_id;
    $trx->delete();
    echo "  → Transaksi ID:{$id} dihapus." . PHP_EOL;

    if ($pembayaranId) {
        // Cek apakah masih ada transaksi lain yang pakai pembayaran ini
        $masihDipakai = TransaksiPenyewaan::where('pembayaran_id', $pembayaranId)->count();
        if ($masihDipakai === 0) {
            Pembayaran::destroy($pembayaranId);
            echo "  → Pembayaran ID:{$pembayaranId} dihapus." . PHP_EOL;
        }
    }
}

// 3. Hapus Order lama (ID 1 dan 2)
foreach ($idsToDelete as $id) {
    $order = Order::find($id);
    if ($order) {
        $order->delete();
        echo "Order ID:{$id} dihapus." . PHP_EOL;
    }
}

echo PHP_EOL . "=== SETELAH HAPUS ===" . PHP_EOL;
echo "Total Transaksi: " . TransaksiPenyewaan::count() . PHP_EOL;
echo "Total Pembayaran: " . Pembayaran::count() . PHP_EOL;
echo "Total Order: " . Order::count() . PHP_EOL;

echo PHP_EOL . "=== SISA TRANSAKSI ===" . PHP_EOL;
TransaksiPenyewaan::with(['barang'])->latest()->get()->each(function($t) {
    $barang = $t->barang ? $t->barang->nama_barang : '-';
    echo "ID:{$t->id} | Barang: {$barang} | Status: {$t->status} | Tgl Sewa: {$t->tanggal_sewa} | Dibuat: {$t->created_at}" . PHP_EOL;
});

echo PHP_EOL . "Selesai!" . PHP_EOL;
