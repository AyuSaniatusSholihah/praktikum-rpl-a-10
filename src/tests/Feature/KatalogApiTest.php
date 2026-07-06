<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class KatalogApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user utama untuk pengujian
        $this->user = User::factory()->create([
            'role' => 'user'
        ]);

        // Buat kategori utama untuk pengujian
        $this->kategori = Kategori::create([
            'nama_kategori' => 'Alat Fotografi',
            'deskripsi' => 'Kamera, Lensa, Tripod, dll.'
        ]);
    }

    /**
     * Test 1: User tidak bisa mengakses katalog API tanpa token (Sanctum)
     */
    public function test_user_cannot_access_katalog_api_without_token()
    {
        $response = $this->getJson('/api/katalog');
        $response->assertStatus(401);

        $responsePost = $this->postJson('/api/katalog', []);
        $responsePost->assertStatus(401);
    }

    /**
     * Test 2: User bisa mendapatkan daftar barang miliknya sendiri
     */
    public function test_user_can_get_all_their_katalog_items()
    {
        // Buat barang milik user utama
        Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Kamera Canon EOS 80D',
            'deskripsi' => 'Kamera DSLR handal',
            'harga_sewa' => 150000,
            'harga_jaminan' => 500000,
            'harga_denda_perjam' => 20000,
            'stok' => 2,
            'lokasi' => 'Surabaya',
            'status' => 'tersedia'
        ]);

        Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Lensa Sony FE 50mm',
            'deskripsi' => 'Lensa prime bokeh',
            'harga_sewa' => 100000,
            'harga_jaminan' => 300000,
            'harga_denda_perjam' => 15000,
            'stok' => 1,
            'lokasi' => 'Surabaya',
            'status' => 'tersedia'
        ]);

        // Buat barang milik user lain
        $otherUser = User::factory()->create();
        Barang::create([
            'user_id' => $otherUser->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Tripod Manfrotto',
            'deskripsi' => 'Tripod kokoh',
            'harga_sewa' => 50000,
            'harga_jaminan' => 150000,
            'harga_denda_perjam' => 5000,
            'stok' => 1,
            'lokasi' => 'Sidoarjo',
            'status' => 'tersedia'
        ]);

        // Login menggunakan Sanctum
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/katalog');

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonCount(2, 'data'); // Hanya ada 2 barang milik user utama

        // Pastikan barang milik user lain tidak ada di dalam respon
        $response->assertJsonMissing([
            'nama_barang' => 'Tripod Manfrotto'
        ]);
    }

    /**
     * Test 3: User bisa menambahkan barang ke katalog mereka sendiri
     */
    public function test_user_can_create_katalog_item()
    {
        Storage::fake('public');
        Sanctum::actingAs($this->user);

        $fakePhoto = UploadedFile::fake()->image('kamera.jpg');

        $payload = [
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Sony A6400',
            'deskripsi' => 'Kamera mirrorless super cepat',
            'harga_sewa' => 180000,
            'harga_jaminan' => 600000,
            'harga_denda_perjam' => 25000,
            'stok' => 1,
            'lokasi' => 'Gresik',
            'foto_barang' => $fakePhoto,
            'status' => 'tersedia'
        ];

        $response = $this->postJson('/api/katalog', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Barang berhasil ditambahkan');

        // Dapatkan nama file yang disimpan secara dinamis
        $barang = Barang::where('nama_barang', 'Sony A6400')->first();
        $this->assertNotNull($barang);
        $this->assertEquals($this->user->id, $barang->user_id);
        
        // Cek apakah file foto benar-benar tersimpan di storage
        $this->assertTrue(Storage::disk('public')->exists($barang->foto_barang));
    }

    /**
     * Test 4: Validasi gagal saat menambahkan barang dengan data tidak lengkap
     */
    public function test_user_cannot_create_katalog_item_with_invalid_data()
    {
        Sanctum::actingAs($this->user);

        // Kirim payload kosong
        $response = $this->postJson('/api/katalog', []);

        $response->assertStatus(422)
            ->assertJsonPath('status', 'error')
            ->assertJsonStructure([
                'status',
                'errors' => [
                    'kategori_id',
                    'nama_barang',
                    'harga_sewa',
                    'harga_jaminan',
                    'harga_denda_perjam',
                    'stok',
                    'lokasi'
                ]
            ]);
    }

    /**
     * Test 5: User bisa melihat detail barang spesifik miliknya
     */
    public function test_user_can_view_specific_katalog_item()
    {
        $barang = Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'DJI Ronin SC',
            'deskripsi' => 'Gimbal kamera stabilizer',
            'harga_sewa' => 120000,
            'harga_jaminan' => 400000,
            'harga_denda_perjam' => 15000,
            'stok' => 1,
            'lokasi' => 'Surabaya',
            'status' => 'tersedia'
        ]);

        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/katalog/{$barang->id}");

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.nama_barang', 'DJI Ronin SC');
    }

    /**
     * Test 6: User tidak bisa melihat barang milik user lain
     */
    public function test_user_cannot_view_other_users_katalog_item()
    {
        $otherUser = User::factory()->create();
        $barang = Barang::create([
            'user_id' => $otherUser->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Barang Rahasia',
            'deskripsi' => 'Deskripsi rahasia',
            'harga_sewa' => 10000,
            'harga_jaminan' => 50000,
            'harga_denda_perjam' => 2000,
            'stok' => 1,
            'lokasi' => 'Malang',
            'status' => 'tersedia'
        ]);

        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/katalog/{$barang->id}");

        $response->assertStatus(404)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('message', 'Barang tidak ditemukan atau bukan milik Anda');
    }

    /**
     * Test 7: User bisa memperbarui barang miliknya
     */
    public function test_user_can_update_katalog_item()
    {
        Storage::fake('public');
        Sanctum::actingAs($this->user);

        $initialPhoto = UploadedFile::fake()->image('foto_lama.jpg');

        $barang = Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Kamera Awal',
            'deskripsi' => 'Deskripsi awal',
            'harga_sewa' => 50000,
            'harga_jaminan' => 150000,
            'harga_denda_perjam' => 5000,
            'stok' => 1,
            'lokasi' => 'Mojokerto',
            'foto_barang' => $initialPhoto->store('katalog', 'public'),
            'status' => 'tersedia'
        ]);

        // Pastikan foto lama ada
        $this->assertTrue(Storage::disk('public')->exists($barang->foto_barang));
        $oldPhotoPath = $barang->foto_barang;

        $newPhoto = UploadedFile::fake()->image('foto_baru.jpg');

        $updatePayload = [
            'nama_barang' => 'Kamera Diperbarui',
            'harga_sewa' => 75000,
            'foto_barang' => $newPhoto
        ];

        $response = $this->putJson("/api/katalog/{$barang->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Barang berhasil diperbarui');

        $barang->refresh();

        $this->assertEquals('Kamera Diperbarui', $barang->nama_barang);
        $this->assertEquals(75000, $barang->harga_sewa);

        // Pastikan foto lama sudah dihapus dan foto baru ada
        $this->assertFalse(Storage::disk('public')->exists($oldPhotoPath));
        $this->assertTrue(Storage::disk('public')->exists($barang->foto_barang));
    }

    /**
     * Test 8: User bisa menghapus barang miliknya
     */
    public function test_user_can_delete_katalog_item()
    {
        Storage::fake('public');
        Sanctum::actingAs($this->user);

        $photo = UploadedFile::fake()->image('foto_hapus.jpg');

        $barang = Barang::create([
            'user_id' => $this->user->id,
            'kategori_id' => $this->kategori->id,
            'nama_barang' => 'Kamera Siap Hapus',
            'deskripsi' => 'Deskripsi',
            'harga_sewa' => 50000,
            'harga_jaminan' => 150000,
            'harga_denda_perjam' => 5000,
            'stok' => 1,
            'lokasi' => 'Mojokerto',
            'foto_barang' => $photo->store('katalog', 'public'),
            'status' => 'tersedia'
        ]);

        $this->assertTrue(Storage::disk('public')->exists($barang->foto_barang));
        $photoPath = $barang->foto_barang;

        $response = $this->deleteJson("/api/katalog/{$barang->id}");

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Barang berhasil dihapus');

        // Pastikan record di database hilang
        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);

        // Pastikan foto di storage juga dihapus
        $this->assertFalse(Storage::disk('public')->exists($photoPath));
    }
}
