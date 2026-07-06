<?php

namespace App\Services;

use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use App\Models\Review;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    /**
     * Checkout seluruh barang di keranjang menjadi transaksi penyewaan.
     */
    public function checkout($user, $keranjangIds = null)
    {
        $query = $user->keranjang()->with('barang');
        if (is_array($keranjangIds) && !empty($keranjangIds)) {
            $query->whereIn('id', $keranjangIds);
        }
        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Keranjang belanja Anda kosong atau item tidak ditemukan, tidak ada yang bisa di-checkout.');
        }

        return DB::transaction(function () use ($user, $cartItems) {
            $transactions = [];
            $totalBayar = 0;
            $requiredStok = [];

            // 1. Hitung total bayar dan agregasi stok yang dibutuhkan per barang
            foreach ($cartItems as $item) {
                $barang = $item->barang;
                $tanggalSewa = Carbon::parse($item->tanggal_sewa);
                $tanggalKembali = Carbon::parse($item->tanggal_kembali_rencana);
                $durasiHari = max(1, $tanggalSewa->diffInDays($tanggalKembali));
                $totalBayar += ((float) $barang->harga_sewa * $item->jumlah * $durasiHari);

                if (!isset($requiredStok[$barang->id])) {
                    $requiredStok[$barang->id] = 0;
                }
                $requiredStok[$barang->id] += $item->jumlah;
            }

            // 2. Cek apakah total stok yang diminta mencukupi
            foreach ($cartItems as $item) {
                $barang = $item->barang;
                if ($barang->stok < $requiredStok[$barang->id]) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}, Anda meminta: {$requiredStok[$barang->id]}.");
                }
            }

            // 2. Cek Saldo dan Kurangi Saldo User
            if ($user->saldo < $totalBayar) {
                throw new \Exception("Saldo Anda tidak mencukupi untuk melakukan checkout. Saldo saat ini: Rp " . number_format($user->saldo, 0, ',', '.'));
            }
            $user->saldo -= $totalBayar;
            $user->save();

            // 3. Buat Pembayaran
            $pembayaran = Pembayaran::create([
                'metode' => 'transfer bank',
                'detail_metode' => 'Saldo Aplikasi (Checkout API)',
                'tanggal_bayar' => now(),
                'jumlah_bayar' => $totalBayar,
            ]);

            // 4. Proses Transaksi
            foreach ($cartItems as $item) {
                $barang = $item->barang;
                $tanggalSewa = Carbon::parse($item->tanggal_sewa);
                $tanggalKembali = Carbon::parse($item->tanggal_kembali_rencana);
                $durasiHari = max(1, $tanggalSewa->diffInDays($tanggalKembali));
                $totalHarga = (float) $barang->harga_sewa * $item->jumlah * $durasiHari;

                // Kurangi Stok
                $barang->stok -= $item->jumlah;
                if ($barang->stok <= 0) {
                    $barang->status = 'tidak_tersedia';
                }
                $barang->save();

                // Tambah saldo ke pemilik barang
                $owner = $barang->user;
                if ($owner) {
                    $owner->saldo += $totalHarga;
                    $owner->save();
                }

                $status = $tanggalSewa->startOfDay()->greaterThan(Carbon::today()) ? 'upcoming' : 'aktif';

                $transaksi = TransaksiPenyewaan::create([
                    'user_id' => $user->id,
                    'barang_id' => $item->barang_id,
                    'pembayaran_id' => $pembayaran->id,
                    'jumlah' => $item->jumlah,
                    'tanggal_sewa' => $item->tanggal_sewa,
                    'waktu_sewa' => $item->waktu_sewa,
                    'tanggal_kembali_rencana' => $item->tanggal_kembali_rencana,
                    'waktu_kembali_rencana' => $item->waktu_kembali_rencana,
                    'status' => $status,
                    'total_harga' => $totalHarga,
                    'jam_terlambat' => 0,
                    'total_denda' => 0,
                ]);

                $transactions[] = $transaksi->load('barang');
                $item->delete();
            }

            return $transactions;
        });
    }

    /**
     * Melakukan pembayaran massal
     */
    public function bayarMassal($user, array $transaksiIds, array $paymentData)
    {
        $transaksis = TransaksiPenyewaan::whereIn('id', $transaksiIds)
            ->where('user_id', $user->id)
            ->with('barang')
            ->get();

        if ($transaksis->count() !== count(array_unique($transaksiIds))) {
            throw new \Exception('Satu atau lebih transaksi tidak ditemukan atau Anda tidak memiliki akses.', 404);
        }

        foreach ($transaksis as $transaksi) {
            if ($transaksi->pembayaran_id !== null) {
                throw new \Exception("Transaksi dengan ID {$transaksi->id} sudah dibayar sebelumnya.");
            }
        }

        $totalBayar = $transaksis->sum('total_harga');

        if ($user->saldo < $totalBayar) {
            throw new \Exception("Saldo Anda tidak mencukupi untuk melakukan pembayaran. Saldo saat ini: Rp " . number_format($user->saldo, 0, ',', '.'));
        }

        return DB::transaction(function () use ($user, $transaksis, $paymentData, $totalBayar) {
            // Kurangi saldo user (penyewa)
            $user->saldo -= $totalBayar;
            $user->save();

            $pembayaran = Pembayaran::create([
                'metode' => $paymentData['metode'],
                'detail_metode' => $paymentData['detail_metode'],
                'tanggal_bayar' => now(),
                'jumlah_bayar' => $totalBayar,
            ]);

            foreach ($transaksis as $transaksi) {
                $barang = Barang::lockForUpdate()->find($transaksi->barang_id);

                if (!$barang) {
                    throw new \Exception("Barang untuk transaksi ID {$transaksi->id} tidak ditemukan.");
                }

                if ($barang->stok < $transaksi->jumlah) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi untuk melakukan pembayaran. Stok saat ini: {$barang->stok}.");
                }

                $barang->stok -= $transaksi->jumlah;
                if ($barang->stok <= 0) {
                    $barang->status = 'tidak_tersedia';
                }
                $barang->save();

                // Tambah saldo ke pemilik barang
                $owner = $barang->user;
                if ($owner) {
                    $owner->saldo += $transaksi->total_harga;
                    $owner->save();
                }

                $transaksi->pembayaran_id = $pembayaran->id;
                $transaksi->status = 'aktif';
                $transaksi->save();
            }

            return [
                'pembayaran' => $pembayaran,
                'transaksi' => $transaksis->load('barang')
            ];
        });
    }

    /**
     * Mengembalikan barang sekaligus mengisi ulasan
     */
    public function kembalikanBarang($user, $id, array $data, $file)
    {
        $transaksi = TransaksiPenyewaan::where('id', $id)
            ->where('user_id', $user->id)
            ->with('barang')
            ->first();

        if (!$transaksi) {
            throw new \Exception('Transaksi tidak ditemukan atau Anda tidak memiliki akses.', 404);
        }

        if ($transaksi->status !== 'aktif') {
            throw new \Exception('Hanya transaksi sewa aktif yang dapat dikembalikan.', 400);
        }

        return DB::transaction(function () use ($transaksi, $data, $user, $file) {
            $now = now();
            $rencanaKembali = Carbon::parse($transaksi->tanggal_kembali_rencana)->endOfDay();
            $jamTerlambat = 0;
            $totalDenda = 0;

            if ($now->greaterThan($rencanaKembali)) {
                $jamTerlambat = (int) ceil($rencanaKembali->diffInHours($now));
                $totalDenda = $jamTerlambat * (float) $transaksi->barang->harga_denda_perjam;
            }

            $path = $file->store('bukti_pengembalian', 'public');

            $transaksi->update([
                'tanggal_kembali_aktual' => $now->toDateString(),
                'status' => 'tunggu verifikasi pengembalian',
                'jam_terlambat' => $jamTerlambat,
                'total_denda' => $totalDenda,
                'foto_buktipengembalian' => $path,
            ]);

            $review = Review::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => $user->id,
                'barang_id' => $transaksi->barang_id,
                'rating' => $data['rating'],
                'komentar' => $data['komentar'] ?? null,
            ]);

            return [
                'transaksi' => $transaksi,
                'review' => $review
            ];
        });
    }

    /**
     * Verifikasi pengembalian barang oleh owner
     */
    public function verifikasiPengembalian($user, $id, array $data)
    {
        $transaksi = TransaksiPenyewaan::where('id', $id)
            ->with('barang')
            ->first();

        if (!$transaksi) {
            throw new \Exception('Transaksi tidak ditemukan.', 404);
        }

        if ($transaksi->status !== 'tunggu verifikasi pengembalian') {
            throw new \Exception('Transaksi tidak sedang menunggu verifikasi pengembalian.', 400);
        }

        if ($transaksi->barang->user_id !== $user->id) {
            throw new \Exception('Anda tidak memiliki akses untuk memverifikasi transaksi ini karena Anda bukan pemilik barang.', 403);
        }

        $isTolak = $data['status_kondisi'] === 'tolak';
        $dendaKerusakan = $isTolak ? (float) $data['denda_kerusakan'] : 0;

        DB::transaction(function () use ($transaksi, $isTolak, $dendaKerusakan) {
            $totalDendaAkhir = $transaksi->total_denda + $dendaKerusakan;

            $transaksi->update([
                'status' => 'selesai',
                'tanggal_verifikasipengembalian' => now(),
                'total_denda' => $totalDendaAkhir
            ]);

            // Jika ada denda (keterlambatan atau kerusakan), potong saldo penyewa, tambah ke owner
            if ($totalDendaAkhir > 0) {
                $renter = $transaksi->user;
                if ($renter) {
                    $renter->saldo -= $totalDendaAkhir;
                    $renter->save();
                }

                $owner = $transaksi->barang->user;
                if ($owner) {
                    $owner->saldo += $totalDendaAkhir;
                    $owner->save();
                }
            }

            if (!$isTolak) {
                $barang = $transaksi->barang;
                $barang->stok += $transaksi->jumlah;
                if ($barang->status === 'tidak_tersedia') {
                    $barang->status = 'tersedia';
                }
                $barang->save();
            }
        });

        $message = $isTolak 
            ? 'Pengembalian barang ditolak (Rusak). Transaksi diselesaikan dengan penambahan denda kerusakan.'
            : 'Pengembalian barang berhasil diverifikasi (Kondisi OK). Transaksi selesai.';

        return [
            'transaksi' => $transaksi->fresh(['barang', 'review']),
            'message' => $message
        ];
    }
}
