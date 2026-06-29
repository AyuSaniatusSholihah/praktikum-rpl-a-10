<?php

namespace Tests\Unit;

use App\Helpers\TransaksiCalculator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Unit Test untuk TransaksiCalculator (Helper class kalkulasi bisnis SEWAIN).
 *
 * Semua test di sini mengikuti pola AAA (Arrange - Act - Assert) dan menguji
 * pure functions yang TIDAK bergantung pada database atau HTTP request.
 *
 * Fungsi yang diuji:
 *  1. hitungDurasiHari()   — Kalkulasi durasi sewa dalam hari
 *  2. hitungTotalHarga()   — Kalkulasi total biaya sewa
 *  3. hitungDenda()        — Kalkulasi denda keterlambatan pengembalian
 *  4. hitungRefundCancelasi() — Kalkulasi refund saat transaksi dibatalkan
 */
class TransaksiCalculatorTest extends TestCase
{
    // =========================================================================
    // GROUP 1: hitungDurasiHari()
    // =========================================================================

    #[Test]
    public function hitungDurasiHari_harus_mengembalikan_1_untuk_sewa_sehari_penuh(): void
    {
        // Arrange: tanggal sewa dan tanggal kembali adalah hari yang sama
        $tanggalSewa    = '2026-07-01';
        $tanggalKembali = '2026-07-01';

        // Act
        $durasi = TransaksiCalculator::hitungDurasiHari($tanggalSewa, $tanggalKembali);

        // Assert: minimum 1 hari (aturan bisnis SEWAIN)
        $this->assertEquals(1, $durasi);
    }

    #[Test]
    public function hitungDurasiHari_harus_mengembalikan_durasi_tepat_untuk_sewa_normal(): void
    {
        // Arrange: sewa 5 malam (1 Juli s.d. 6 Juli)
        $tanggalSewa    = '2026-07-01';
        $tanggalKembali = '2026-07-06';

        // Act
        $durasi = TransaksiCalculator::hitungDurasiHari($tanggalSewa, $tanggalKembali);

        // Assert
        $this->assertEquals(5, $durasi);
    }

    #[Test]
    public function hitungDurasiHari_harus_mengembalikan_1_jika_tanggal_kembali_sebelum_sewa(): void
    {
        // Arrange: edge case — tanggal kembali lebih awal dari tanggal sewa
        // (input tidak valid, tapi fungsi harus tetap mengembalikan minimum 1)
        $tanggalSewa    = '2026-07-05';
        $tanggalKembali = '2026-07-03'; // lebih awal

        // Act
        $durasi = TransaksiCalculator::hitungDurasiHari($tanggalSewa, $tanggalKembali);

        // Assert: hasil max(1, diffInDays) = max(1, 0) = 1
        $this->assertGreaterThanOrEqual(1, $durasi);
    }

    #[Test]
    public function hitungDurasiHari_harus_bekerja_dengan_format_tanggal_berbeda(): void
    {
        // Arrange: format Y-m-d H:i:s (dari datetime column)
        $tanggalSewa    = '2026-08-10 08:00:00';
        $tanggalKembali = '2026-08-13 14:30:00';

        // Act
        $durasi = TransaksiCalculator::hitungDurasiHari($tanggalSewa, $tanggalKembali);

        // Assert: startOfDay ke startOfDay = 3 hari
        $this->assertEquals(3, $durasi);
    }

    // =========================================================================
    // GROUP 2: hitungTotalHarga()
    // =========================================================================

    #[Test]
    public function hitungTotalHarga_harus_menghasilkan_perkalian_yang_benar(): void
    {
        // Arrange: sewa kamera @ Rp 150.000/hari × 2 unit × 4 hari
        $hargaSewa  = 150000.0;
        $jumlah     = 2;
        $durasiHari = 4;

        // Act
        $total = TransaksiCalculator::hitungTotalHarga($hargaSewa, $jumlah, $durasiHari);

        // Assert: 150000 × 2 × 4 = 1.200.000
        $this->assertEquals(1_200_000.0, $total);
    }

    #[Test]
    public function hitungTotalHarga_harus_mengembalikan_nol_jika_harga_sewa_nol(): void
    {
        // Arrange: edge case — barang gratis (harga = 0)
        $hargaSewa  = 0.0;
        $jumlah     = 3;
        $durasiHari = 7;

        // Act
        $total = TransaksiCalculator::hitungTotalHarga($hargaSewa, $jumlah, $durasiHari);

        // Assert
        $this->assertEquals(0.0, $total);
    }

    #[Test]
    public function hitungTotalHarga_harus_benar_untuk_satu_unit_satu_hari(): void
    {
        // Arrange: happy case paling sederhana
        $hargaSewa  = 50000.0;
        $jumlah     = 1;
        $durasiHari = 1;

        // Act
        $total = TransaksiCalculator::hitungTotalHarga($hargaSewa, $jumlah, $durasiHari);

        // Assert
        $this->assertEquals(50000.0, $total);
    }

    // =========================================================================
    // GROUP 3: hitungDenda()
    // =========================================================================

    #[Test]
    public function hitungDenda_harus_mengembalikan_nol_jika_dikembalikan_tepat_waktu(): void
    {
        // Arrange: dikembalikan pada hari yang sama dengan rencana (sebelum 23:59)
        $tanggalRencana = '2026-07-10';
        $waktuAktual    = '2026-07-10 15:00:00'; // masih dalam hari yang sama
        $dendaPerJam    = 15000.0;

        // Act
        $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

        // Assert: tidak ada keterlambatan
        $this->assertEquals(0, $result['jam_terlambat']);
        $this->assertEquals(0.0, $result['total_denda']);
    }

    #[Test]
    public function hitungDenda_harus_mengembalikan_nol_jika_dikembalikan_lebih_awal(): void
    {
        // Arrange: dikembalikan sehari SEBELUM rencana (lebih awal)
        $tanggalRencana = '2026-07-10';
        $waktuAktual    = '2026-07-09 10:00:00';
        $dendaPerJam    = 20000.0;

        // Act
        $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

        // Assert
        $this->assertEquals(0, $result['jam_terlambat']);
        $this->assertEquals(0.0, $result['total_denda']);
    }

    #[Test]
    public function hitungDenda_harus_menghitung_denda_dengan_benar_jika_terlambat(): void
    {
        // Arrange: rencana kembali 10 Juli, aktual kembali 11 Juli jam 03:00
        // Batas akhir: 10 Juli 23:59:59 — terlambat ~3 jam
        $tanggalRencana = '2026-07-10';
        $waktuAktual    = '2026-07-11 02:59:59'; // +3 jam dari 23:59:59
        $dendaPerJam    = 10000.0;

        // Act
        $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

        // Assert: 3 jam terlambat → 3 × 10000 = 30000
        $this->assertEquals(3, $result['jam_terlambat']);
        $this->assertEquals(30000.0, $result['total_denda']);
    }

    #[Test]
    public function hitungDenda_harus_membulatkan_jam_terlambat_ke_atas(): void
    {
        // Arrange: terlambat 1 jam 1 menit → harus dibulatkan jadi 2 jam (ceil)
        $tanggalRencana = '2026-07-10';
        $waktuAktual    = '2026-07-11 01:01:00'; // 1 jam 1 menit setelah 23:59:59 = ceil(1.01) = 2 jam
        $dendaPerJam    = 15000.0;

        // Act
        $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

        // Assert: dibulatkan ke atas → 2 jam → 2 × 15000 = 30000
        $this->assertEquals(2, $result['jam_terlambat']);
        $this->assertEquals(30000.0, $result['total_denda']);
    }

    // =========================================================================
    // GROUP 4: hitungRefundCancelasi()
    // =========================================================================

    #[Test]
    public function hitungRefundCancelasi_harus_mengembalikan_total_yang_benar_untuk_kasus_normal(): void
    {
        // Arrange: total_harga = 300.000, durasi = 2 hari, shipping default 20.000
        // hargaPerHari = 300000 / 2 = 150000
        // jaminan      = round(150000 / 2) = 75000
        // refund       = 300000 + 75000 + 20000 = 395000
        $totalHarga = 300000.0;
        $durasiHari = 2;

        // Act
        $refund = TransaksiCalculator::hitungRefundCancelasi($totalHarga, $durasiHari);

        // Assert
        $this->assertEquals(395000.0, $refund);
    }

    #[Test]
    public function hitungRefundCancelasi_harus_menggunakan_durasi_1_jika_durasi_nol(): void
    {
        // Arrange: edge case — durasi = 0 (situasi tak normal, cegah division by zero)
        // Dengan durasi dipaksa jadi 1: hargaPerHari = 150000/1 = 150000
        // jaminan = round(75000) = 75000
        // refund = 150000 + 75000 + 20000 = 245000
        $totalHarga = 150000.0;
        $durasiHari = 0; // edge case: durasi 0

        // Act
        $refund = TransaksiCalculator::hitungRefundCancelasi($totalHarga, $durasiHari);

        // Assert: tidak throw error, dan hitungan pakai durasi = 1
        $this->assertEquals(245000.0, $refund);
    }

    #[Test]
    public function hitungRefundCancelasi_harus_menerima_shipping_fee_kustom(): void
    {
        // Arrange: total_harga = 200.000, durasi = 1 hari, shipping kustom = 0
        // hargaPerHari = 200000 / 1 = 200000
        // jaminan      = round(200000 / 2) = 100000
        // refund       = 200000 + 100000 + 0 = 300000
        $totalHarga  = 200000.0;
        $durasiHari  = 1;
        $shippingFee = 0;

        // Act
        $refund = TransaksiCalculator::hitungRefundCancelasi($totalHarga, $durasiHari, $shippingFee);

        // Assert
        $this->assertEquals(300000.0, $refund);
    }
}
