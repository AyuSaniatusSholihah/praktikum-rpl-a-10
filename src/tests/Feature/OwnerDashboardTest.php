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

class OwnerDashboardTest extends TestCase
{
    use RefreshDatabase;

    private $owner;
    private $renter;
    private $kategori;
    private $barang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'role' => 'user',
            'saldo' => 50000.00
        ]);

        $this->renter = User::factory()->create([
            'role' => 'user'
        ]);

        $this->kategori = Kategori::create([
            'nama_kategori' => 'Elektronik',
            'deskripsi' => 'Barang elektronik'
        ]);

        $this->barang = Barang::create([
            'user_id' => $this->owner->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Kamera Sony A7III',
            'deskripsi' => 'Kamera mirrorless professional',
            'harga_sewa' => 200000,
            'harga_jaminan' => 1000000,
            'harga_denda_perjam' => 30000,
            'stok' => 5,
            'lokasi' => 'Surabaya',
            'status' => 'tersedia'
        ]);
    }

    /**
     * Test Owner Dashboard data
     */
    public function test_owner_can_view_dashboard_with_transactions_and_saldo()
    {
        // Buat pembayaran
        $pembayaran = Pembayaran::create([
            'metode' => 'qris',
            'detail_metode' => 'Gopay',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 400000,
        ]);

        // Buat transaksi sewa aktif
        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->renter->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 400000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->owner);

        $response = $this->getJson('/api/owner/dashboard');

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.owner_name', $this->owner->name)
            ->assertJsonPath('data.saldo_user', 50000)
            ->assertJsonPath('data.total_saldo_pendapatan', 400000)
            ->assertJsonPath('data.total_barang', 1)
            ->assertJsonCount(1, 'data.daftar_transaksi');
    }

    /**
     * Test Owner can view specific transaction detail
     */
    public function test_owner_can_view_specific_transaction_detail()
    {
        $pembayaran = Pembayaran::create([
            'metode' => 'qris',
            'detail_metode' => 'Gopay',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 400000,
        ]);

        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->renter->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 400000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->owner);

        $response = $this->getJson("/api/owner/transaksi/{$transaksi->id}");

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $transaksi->id)
            ->assertJsonPath('data.total_harga', 400000);
    }

    /**
     * Test Owner cannot view transaction of another owner's item
     */
    public function test_owner_cannot_view_other_owners_transaction_detail()
    {
        $otherOwner = User::factory()->create();
        $otherBarang = Barang::create([
            'user_id' => $otherOwner->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Barang Lain',
            'deskripsi' => 'Deskripsi barang lain',
            'harga_sewa' => 50000,
            'harga_jaminan' => 100000,
            'harga_denda_perjam' => 5000,
            'stok' => 1,
            'lokasi' => 'Gresik',
            'status' => 'tersedia'
        ]);

        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->renter->id,
            'barang_id' => $otherBarang->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'upcoming',
            'total_harga' => 100000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->owner);

        $response = $this->getJson("/api/owner/transaksi/{$transaksi->id}");

        $response->assertStatus(403)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('message', 'Anda tidak memiliki akses untuk melihat detail transaksi ini.');
    }
}
