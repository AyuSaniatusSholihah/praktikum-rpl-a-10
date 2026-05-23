<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RenterTransactionTest extends TestCase
{
    use RefreshDatabase;

    private $renter;
    private $otherRenter;
    private $owner;
    private $kategori;
    private $barang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create(['role' => 'user']);
        $this->renter = User::factory()->create(['role' => 'user']);
        $this->otherRenter = User::factory()->create(['role' => 'user']);

        $this->kategori = Kategori::create([
            'nama_kategori' => 'Kamera',
            'deskripsi' => 'Alat dokumentasi'
        ]);

        $this->barang = Barang::create([
            'user_id' => $this->owner->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Fujifilm X-T30',
            'deskripsi' => 'Mirrorless camera',
            'harga_sewa' => 150000,
            'harga_jaminan' => 500000,
            'harga_denda_perjam' => 15000,
            'stok' => 3,
            'lokasi' => 'Surabaya',
            'status' => 'tersedia'
        ]);
    }

    /**
     * Test Renter can get their own transaction history
     */
    public function test_renter_can_get_their_own_transaction_history()
    {
        $pembayaran = Pembayaran::create([
            'metode' => 'transfer bank',
            'detail_metode' => 'BCA',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 300000,
        ]);

        // Transaksi milik renter aktif
        TransaksiPenyewaan::create([
            'user_id' => $this->renter->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 300000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        // Transaksi milik renter lain
        TransaksiPenyewaan::create([
            'user_id' => $this->otherRenter->id,
            'barang_id' => $this->barang->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(1)->toDateString(),
            'status' => 'upcoming',
            'total_harga' => 150000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->renter);

        $response = $this->getJson('/api/transaksi');

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonCount(1, 'data'); // Hanya mengembalikan transaksi milik renter aktif
    }

    /**
     * Test Renter can get detail of their own transaction
     */
    public function test_renter_can_view_specific_transaction_detail()
    {
        $pembayaran = Pembayaran::create([
            'metode' => 'transfer bank',
            'detail_metode' => 'BCA',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 300000,
        ]);

        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->renter->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 300000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->renter);

        $response = $this->getJson("/api/transaksi/{$transaksi->id}");

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $transaksi->id)
            ->assertJsonPath('data.total_harga', 300000);
    }

    /**
     * Test Renter cannot view transaction details of other renters
     */
    public function test_renter_cannot_view_other_renters_transaction_detail()
    {
        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->otherRenter->id,
            'barang_id' => $this->barang->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(1)->toDateString(),
            'status' => 'upcoming',
            'total_harga' => 150000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->renter);

        $response = $this->getJson("/api/transaksi/{$transaksi->id}");

        $response->assertStatus(404)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('message', 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.');
    }
}
