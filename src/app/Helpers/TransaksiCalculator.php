<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * TransaksiCalculator
 *
 * Kumpulan pure static functions untuk kalkulasi bisnis transaksi penyewaan.
 * Semua method di sini TIDAK menyentuh database, hanya menerima nilai primitif
 * dan mengembalikan hasil — membuatnya sangat mudah dan bersih untuk diuji.
 *
 * Diekstrak dari TransaksiService agar logic kalkulasi bisa diuji secara terisolasi.
 */
class TransaksiCalculator
{
    /**
     * Hitung durasi sewa dalam hari.
     *
     * Aturan bisnis:
     * - Minimum 1 hari (walau tanggal sewa = tanggal kembali, tetap dihitung 1 hari).
     * - Tanggal kembali TIDAK boleh sebelum tanggal sewa (validasi di luar fungsi ini).
     *
     * @param  string|Carbon  $tanggalSewa   Tanggal mulai sewa (Y-m-d atau Carbon)
     * @param  string|Carbon  $tanggalKembali Tanggal rencana kembali (Y-m-d atau Carbon)
     * @return int  Durasi sewa dalam hari (minimal 1)
     */
    public static function hitungDurasiHari($tanggalSewa, $tanggalKembali): int
    {
        $mulai  = Carbon::parse($tanggalSewa)->startOfDay();
        $selesai = Carbon::parse($tanggalKembali)->startOfDay();

        return max(1, (int) $mulai->diffInDays($selesai));
    }

    /**
     * Hitung total harga sewa.
     *
     * Formula: harga_sewa × jumlah × durasi_hari
     *
     * @param  float  $hargaSewa    Harga sewa per unit per hari (Rupiah)
     * @param  int    $jumlah       Jumlah unit yang disewa
     * @param  int    $durasiHari   Durasi sewa dalam hari
     * @return float  Total harga yang harus dibayar (Rupiah)
     */
    public static function hitungTotalHarga(float $hargaSewa, int $jumlah, int $durasiHari): float
    {
        return $hargaSewa * $jumlah * $durasiHari;
    }

    /**
     * Hitung total denda keterlambatan pengembalian.
     *
     * Aturan bisnis:
     * - Jika dikembalikan SETELAH batas akhir hari pengembalian (endOfDay),
     *   dihitung denda per jam dengan pembulatan ke ATAS (ceil).
     * - Jika tepat waktu atau lebih awal, denda = 0.
     *
     * @param  string|Carbon  $tanggalKembaliRencana  Tanggal rencana kembali
     * @param  string|Carbon  $waktuKembaliAktual     Waktu aktual saat barang dikembalikan
     * @param  float          $hargaDendaPerJam       Harga denda per jam (Rupiah)
     * @return array{jam_terlambat: int, total_denda: float}
     */
    public static function hitungDenda($tanggalKembaliRencana, $waktuKembaliAktual, float $hargaDendaPerJam): array
    {
        $batasAkhir   = Carbon::parse($tanggalKembaliRencana)->endOfDay();
        $aktual       = Carbon::parse($waktuKembaliAktual);

        if (!$aktual->greaterThan($batasAkhir)) {
            return ['jam_terlambat' => 0, 'total_denda' => 0.0];
        }

        $jamTerlambat = (int) ceil($batasAkhir->diffInHours($aktual));
        $totalDenda   = $jamTerlambat * $hargaDendaPerJam;

        return [
            'jam_terlambat' => $jamTerlambat,
            'total_denda'   => $totalDenda,
        ];
    }

    /**
     * Hitung jumlah refund saat transaksi dibatalkan (status 'upcoming').
     *
     * Aturan bisnis:
     * - Refund = total_harga + setengah_harga_jaminan + biaya_pengiriman_tetap
     * - setengah_harga_jaminan dihitung sebagai: (total_harga / durasi_hari) / 2
     * - Durasi minimum tetap 1 hari untuk menghindari pembagian nol.
     * - Biaya pengiriman tetap (shipping fee) = Rp 20.000
     *
     * @param  float  $totalHarga           Total harga transaksi yang sudah dibayar
     * @param  int    $durasiHari           Durasi sewa dalam hari
     * @param  int    $shippingFee          Biaya pengiriman tetap (default 20000)
     * @return float  Jumlah total yang dikembalikan ke saldo penyewa (Rupiah)
     */
    public static function hitungRefundCancelasi(float $totalHarga, int $durasiHari, int $shippingFee = 20000): float
    {
        // Pastikan durasi minimal 1 untuk menghindari pembagian dengan nol
        $durasi = max(1, $durasiHari);

        $hargaPerHari = $totalHarga / $durasi;
        $jaminan      = (int) round($hargaPerHari / 2);

        return $totalHarga + $jaminan + $shippingFee;
    }
}
