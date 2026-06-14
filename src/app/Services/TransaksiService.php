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
    public function checkout($user)
    {
        $cartItems = $user->keranjang()->with('barang')->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Keranjang belanja Anda kosong, tidak ada yang bisa di-checkout.');
        }

        return DB::transaction(function () use ($user, $cartItems) {
            $transactions = [];

            foreach ($cartItems as $item) {
                $barang = $item->barang;

                if ($barang->stok < $item->jumlah) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}.");
                }

                $tanggalSewa = Carbon::parse($item->tanggal_sewa);
                $tanggalKembali = Carbon::parse($item->tanggal_kembali_rencana);
                $durasiHari = max(1, $tanggalSewa->diffInDays($tanggalKembali));
                
                $totalHarga = (float) $barang->harga_sewa * $item->jumlah * $durasiHari;

                $transaksi = TransaksiPenyewaan::create([
                    'user_id' => $user->id,
                    'barang_id' => $item->barang_id,
                    'jumlah' => $item->jumlah,
                    'tanggal_sewa' => $item->tanggal_sewa,
                    'tanggal_kembali_rencana' => $item->tanggal_kembali_rencana,
                    'status' => 'upcoming',
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

        return DB::transaction(function () use ($transaksis, $paymentData, $totalBayar) {
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
            $transaksi->update([
                'status' => 'selesai',
                'tanggal_verifikasipengembalian' => now(),
                'total_denda' => $transaksi->total_denda + $dendaKerusakan
            ]);

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
