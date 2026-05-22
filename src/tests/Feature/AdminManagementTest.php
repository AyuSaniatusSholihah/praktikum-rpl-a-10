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

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;
    private $kategori;
    private $barang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->user = User::factory()->create([
            'role' => 'user'
        ]);

        $this->kategori = Kategori::create([
            'nama_kategori' => 'Alat Camping',
            'deskripsi' => 'Tenda, Carrier, Nesting, dll.'
        ]);

        $this->barang = Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Tenda Dome 4P',
            'deskripsi' => 'Tenda kapasitas 4 orang waterproof',
            'harga_sewa' => 50000,
            'harga_jaminan' => 150000,
            'harga_denda_perjam' => 5000,
            'stok' => 4,
            'lokasi' => 'Malang',
            'status' => 'tersedia'
        ]);
    }

    /**
     * Test Non-Admin cannot access Admin endpoints
     */
    public function test_non_admin_cannot_access_admin_endpoints()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/admin/dashboard');
        $response->assertStatus(403)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('message', 'Akses ditolak. Halaman ini hanya untuk Admin.');

        $responseBan = $this->postJson("/api/admin/users/{$this->user->id}/toggle-ban");
        $responseBan->assertStatus(403);
    }

    /**
     * Test Admin can view Dashboard Summary
     */
    public function test_admin_can_view_dashboard_summary()
    {
        $pembayaran = Pembayaran::create([
            'metode' => 'qris',
            'detail_metode' => 'ShopeePay',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 100000,
        ]);

        TransaksiPenyewaan::create([
            'user_id' => $this->user->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 100000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/admin/dashboard');

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.summary.total_users', 1)
            ->assertJsonPath('data.summary.total_items', 1)
            ->assertJsonPath('data.summary.total_transactions', 1)
            ->assertJsonPath('data.summary.total_financial_wallet', 100000);
    }

    /**
     * Test Admin can view tab listings
     */
    public function test_admin_can_view_tab_listings()
    {
        Sanctum::actingAs($this->admin);

        // Test list users
        $responseUsers = $this->getJson('/api/admin/users');
        $responseUsers->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonCount(1, 'data'); // Hanya user utama ($this->user), admin tidak dihitung di user list

        // Test list items
        $responseItems = $this->getJson('/api/admin/items');
        $responseItems->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonCount(1, 'data');

        // Test list transactions
        $responseTransactions = $this->getJson('/api/admin/transactions');
        $responseTransactions->assertStatus(200)
            ->assertJsonPath('status', 'success');

        // Test list finance/payments
        $responseFinance = $this->getJson('/api/admin/finance');
        $responseFinance->assertStatus(200)
            ->assertJsonPath('status', 'success');
    }

    /**
     * Test Admin can view detail pages
     */
    public function test_admin_can_view_detail_pages()
    {
        $pembayaran = Pembayaran::create([
            'metode' => 'qris',
            'detail_metode' => 'ShopeePay',
            'tanggal_bayar' => now(),
            'jumlah_bayar' => 100000,
        ]);

        $transaksi = TransaksiPenyewaan::create([
            'user_id' => $this->user->id,
            'barang_id' => $this->barang->id,
            'pembayaran_id' => $pembayaran->id,
            'jumlah' => 1,
            'tanggal_sewa' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'aktif',
            'total_harga' => 100000,
            'jam_terlambat' => 0,
            'total_denda' => 0,
        ]);

        Sanctum::actingAs($this->admin);

        // Test User Detail
        $responseUser = $this->getJson("/api/admin/users/{$this->user->id}");
        $responseUser->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $this->user->id);

        // Test Item Detail
        $responseItem = $this->getJson("/api/admin/items/{$this->barang->id}");
        $responseItem->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $this->barang->id);

        // Test Transaction Detail
        $responseTransaction = $this->getJson("/api/admin/transactions/{$transaksi->id}");
        $responseTransaction->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $transaksi->id);

        // Test Payment Detail
        $responsePayment = $this->getJson("/api/admin/finance/{$pembayaran->id}");
        $responsePayment->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.payment.id', $pembayaran->id);
    }

    /**
     * Test Admin can toggle ban status of a user
     */
    public function test_admin_can_toggle_ban_status_of_user()
    {
        Sanctum::actingAs($this->admin);

        $this->user->refresh();
        // Awalnya user tidak dibanned
        $this->assertFalse($this->user->is_banned);

        // Ban user
        $responseBan = $this->postJson("/api/admin/users/{$this->user->id}/toggle-ban");
        $responseBan->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'User berhasil di-ban.')
            ->assertJsonPath('data.is_banned', true);

        $this->user->refresh();
        $this->assertTrue($this->user->is_banned);

        // Unban user
        $responseUnban = $this->postJson("/api/admin/users/{$this->user->id}/toggle-ban");
        $responseUnban->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Ban user berhasil dicabut.')
            ->assertJsonPath('data.is_banned', false);

        $this->user->refresh();
        $this->assertFalse($this->user->is_banned);
    }
}
