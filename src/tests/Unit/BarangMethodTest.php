<?php

namespace Tests\Unit;

use App\Models\Barang;
use PHPUnit\Framework\TestCase;

/**
 * Unit Test untuk method-method pada Model Barang.
 *
 * Test ini menguji business logic method yang bersifat "pure" (hanya
 * bergantung pada state internal objek, tanpa database atau HTTP request).
 *
 * Pola yang digunakan: AAA (Arrange - Act - Assert)
 */
class BarangMethodTest extends TestCase
{
    // =====================================================================
    // UNIT TEST 3: semuaFoto()
    // Menguji method yang mengumpulkan semua foto produk yang terisi.
    // =====================================================================

    /**
     * @test
     * [semuaFoto] Harus mengembalikan array berisi semua path foto yang tidak null/kosong.
     */
    public function test_semuaFoto_returns_only_filled_photo_paths(): void
    {
        // --- ARRANGE ---
        // Siapkan objek Barang dengan beberapa foto terisi dan beberapa null
        $barang = new Barang();
        $barang->foto_barang  = 'katalog/foto_utama.jpg';
        $barang->fotoproduk1  = 'katalog/foto_sudut1.jpg';
        $barang->fotoproduk2  = null;  // foto ini kosong/null
        $barang->fotoproduk3  = 'katalog/foto_sudut3.jpg';
        $barang->fotoproduk4  = null;  // foto ini juga kosong/null

        // --- ACT ---
        // Panggil method yang ingin diuji
        $result = $barang->semuaFoto();

        // --- ASSERT ---
        // Harusnya hanya 3 foto yang terisi yang dikembalikan
        $this->assertCount(3, $result);
        $this->assertContains('katalog/foto_utama.jpg', $result);
        $this->assertContains('katalog/foto_sudut1.jpg', $result);
        $this->assertContains('katalog/foto_sudut3.jpg', $result);
        // Pastikan nilai null tidak masuk ke hasil
        $this->assertNotContains(null, $result);
    }

    /**
     * @test
     * [semuaFoto] Harus mengembalikan array kosong jika semua field foto bernilai null.
     */
    public function test_semuaFoto_returns_empty_array_when_all_photos_are_null(): void
    {
        // --- ARRANGE ---
        // Barang baru tanpa satu pun foto yang diisi
        $barang = new Barang();
        $barang->foto_barang  = null;
        $barang->fotoproduk1  = null;
        $barang->fotoproduk2  = null;
        $barang->fotoproduk3  = null;
        $barang->fotoproduk4  = null;

        // --- ACT ---
        $result = $barang->semuaFoto();

        // --- ASSERT ---
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @test
     * [semuaFoto] Harus mengembalikan array dengan 1 elemen jika hanya foto utama yang terisi.
     */
    public function test_semuaFoto_returns_single_element_when_only_main_photo_is_filled(): void
    {
        // --- ARRANGE ---
        $barang = new Barang();
        $barang->foto_barang  = 'katalog/satu-satunya-foto.jpg';
        $barang->fotoproduk1  = null;
        $barang->fotoproduk2  = null;
        $barang->fotoproduk3  = null;
        $barang->fotoproduk4  = null;

        // --- ACT ---
        $result = $barang->semuaFoto();

        // --- ASSERT ---
        $this->assertCount(1, $result);
        $this->assertEquals('katalog/satu-satunya-foto.jpg', $result[0]);
    }

    // =====================================================================
    // UNIT TEST 4: statusLabel()
    // Menguji method yang mengonversi status barang ke label bahasa Inggris.
    // =====================================================================

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'AVAILABLE' untuk status 'tersedia'.
     */
    public function test_statusLabel_returns_AVAILABLE_for_status_tersedia(): void
    {
        // --- ARRANGE ---
        $barang = new Barang();
        $barang->status = 'tersedia';

        // --- ACT ---
        $result = $barang->statusLabel();

        // --- ASSERT ---
        $this->assertEquals('AVAILABLE', $result);
    }

    /**
     * @test
     * [statusLabel] Harus mengembalikan 'ACTIVE RENTAL' untuk status selain 'tersedia'.
     */
    public function test_statusLabel_returns_ACTIVE_RENTAL_for_non_tersedia_status(): void
    {
        // --- ARRANGE ---
        $barang = new Barang();
        $barang->status = 'disewa'; // status selain 'tersedia'

        // --- ACT ---
        $result = $barang->statusLabel();

        // --- ASSERT ---
        $this->assertEquals('ACTIVE RENTAL', $result);
    }

    // =====================================================================
    // UNIT TEST 5: getShortLocationAttribute()
    // Menguji method getter yang memformat lokasi panjang menjadi nama kota singkat.
    // =====================================================================

    /**
     * @test
     * [getShortLocationAttribute] Harus mengekstrak nama kota terakhir dari lokasi yang dipisahkan koma.
     */
    public function test_getShortLocationAttribute_extracts_last_segment_from_comma_separated_location(): void
    {
        // --- ARRANGE ---
        // Lokasi lengkap berisi beberapa segmen yang dipisahkan koma
        $barang = new Barang();
        $barang->lokasi = 'Jl. Slamet Riyadi, Laweyan, Surakarta';

        // --- ACT ---
        // Karena ini adalah accessor (Attribute), kita panggil sebagai property
        $result = $barang->short_location;

        // --- ASSERT ---
        // Hanya nama kota akhir yang dikembalikan, dengan ucfirst
        $this->assertEquals('Surakarta', $result);
    }

    /**
     * @test
     * [getShortLocationAttribute] Harus menghapus prefix 'Kab' atau 'Kota' di awal segmen kota.
     */
    public function test_getShortLocationAttribute_removes_kab_or_kota_prefix(): void
    {
        // --- ARRANGE ---
        $barang = new Barang();
        // 'Kab' adalah prefix umum untuk Kabupaten, harus dihapus
        $barang->lokasi = 'Jl. Pratama No. 5, Kab Sleman';

        // --- ACT ---
        $result = $barang->short_location;

        // --- ASSERT ---
        // Prefix 'Kab ' harus dihapus, sisa nama kota tetap
        $this->assertEquals('Sleman', $result);
    }

    /**
     * @test
     * [getShortLocationAttribute] Harus mengembalikan string kosong jika lokasi tidak diisi (null).
     */
    public function test_getShortLocationAttribute_returns_empty_string_when_lokasi_is_null(): void
    {
        // --- ARRANGE ---
        $barang = new Barang();
        $barang->lokasi = null; // edge case: lokasi tidak diisi

        // --- ACT ---
        $result = $barang->short_location;

        // --- ASSERT ---
        $this->assertEquals('', $result);
    }
}
