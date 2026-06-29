<?php

namespace Tests\Unit;

use App\Models\TransaksiPenyewaan;
use PHPUnit\Framework\TestCase;

/**
 * Unit Test untuk method-method pada Model TransaksiPenyewaan.
 *
 * Test ini menguji business logic method yang bersifat "pure" (hanya
 * bergantung pada state internal objek, tanpa database atau HTTP request).
 *
 * Pola yang digunakan: AAA (Arrange - Act - Assert)
 */
class TransaksiPenyewaanMethodTest extends TestCase
{
    // =====================================================================
    // UNIT TEST 1: statusLabel()
    // Menguji metode yang mengonversi nilai status internal ke label
    // yang dapat dibaca oleh pengguna (human-readable label).
    // =====================================================================

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'Active Rent' untuk status 'aktif'.
     */
    public function test_statusLabel_returns_Active_Rent_for_status_aktif(): void
    {
        // --- ARRANGE ---
        // Buat objek TransaksiPenyewaan dan set properti status-nya
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'aktif';

        // --- ACT ---
        // Panggil method yang ingin diuji
        $result = $transaksi->statusLabel();

        // --- ASSERT ---
        // Verifikasi bahwa hasilnya sesuai dengan yang diharapkan
        $this->assertEquals('Active Rent', $result);
    }

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'Completed Rent' untuk status 'selesai'.
     */
    public function test_statusLabel_returns_Completed_Rent_for_status_selesai(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'selesai';

        // --- ACT ---
        $result = $transaksi->statusLabel();

        // --- ASSERT ---
        $this->assertEquals('Completed Rent', $result);
    }

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'UpComing Rent' untuk status 'upcoming'.
     */
    public function test_statusLabel_returns_UpComing_Rent_for_status_upcoming(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'upcoming';

        // --- ACT ---
        $result = $transaksi->statusLabel();

        // --- ASSERT ---
        $this->assertEquals('UpComing Rent', $result);
    }

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'Cancelled Rent' untuk status 'dibatalkan'.
     */
    public function test_statusLabel_returns_Cancelled_Rent_for_status_dibatalkan(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'dibatalkan';

        // --- ACT ---
        $result = $transaksi->statusLabel();

        // --- ASSERT ---
        $this->assertEquals('Cancelled Rent', $result);
    }

    /**
     * @test
     * [statusLabel] Untuk status yang tidak dikenal, harus me-ucfirst string status aslinya (fallback).
     */
    public function test_statusLabel_returns_ucfirst_of_unknown_status_as_fallback(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'status_baru_tak_dikenal';

        // --- ACT ---
        $result = $transaksi->statusLabel();

        // --- ASSERT ---
        // Fallback: ucfirst dari string status asli (karena tidak ada di mapping)
        $this->assertEquals('Status_baru_tak_dikenal', $result);
    }

    // =====================================================================
    // UNIT TEST 2: statusBadgeClass()
    // Menguji metode yang mengembalikan class CSS badge sesuai status.
    // =====================================================================

    /**
     * @test
     * [statusBadgeClass] Harus mengembalikan class 'badge-active' untuk status 'aktif'.
     */
    public function test_statusBadgeClass_returns_badge_active_for_status_aktif(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'aktif';

        // --- ACT ---
        $result = $transaksi->statusBadgeClass();

        // --- ASSERT ---
        $this->assertEquals('badge-active', $result);
    }

    /**
     * @test
     * [statusBadgeClass] Harus mengembalikan class 'badge-completed' untuk status 'selesai'.
     */
    public function test_statusBadgeClass_returns_badge_completed_for_status_selesai(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'selesai';

        // --- ACT ---
        $result = $transaksi->statusBadgeClass();

        // --- ASSERT ---
        $this->assertEquals('badge-completed', $result);
    }

    /**
     * @test
     * [statusBadgeClass] Untuk status yang tidak dikenal, harus mengembalikan 'badge-upcoming' sebagai default.
     */
    public function test_statusBadgeClass_returns_badge_upcoming_as_default_for_unknown_status(): void
    {
        // --- ARRANGE ---
        $transaksi = new TransaksiPenyewaan();
        $transaksi->status = 'status_tidak_valid_xyz';

        // --- ACT ---
        $result = $transaksi->statusBadgeClass();

        // --- ASSERT ---
        $this->assertEquals('badge-upcoming', $result);
    }
}
