# Laporan Praktikum P10 — Unit Testing

**Mata Kuliah:** Rekayasa Perangkat Lunak (RPL)  
**Modul:** P10 — Unit Test Minimal dengan Pola AAA  
**Project:** SEWAIN — Platform Sewa Barang Peer-to-Peer  
**Framework Testing:** PHPUnit (built-in Laravel)  
**Tanggal:** 29 Juni 2026  

---

## A. Tujuan Pembelajaran

Pada praktikum modul P10 ini, tujuan yang ingin dicapai adalah:

1. **Memahami konsep unit testing** sebagai bagian dari proses pengembangan perangkat lunak yang profesional.
2. **Memahami dan menerapkan pola AAA** (Arrange–Act–Assert) sebagai struktur standar penulisan unit test yang terstruktur dan mudah dibaca.
3. **Menulis minimal 3 unit test** untuk fungsi atau modul yang paling kritis di project SEWAIN.
4. **Menjalankan unit test** menggunakan `php artisan test` dan menginterpretasikan hasilnya.

---

## B. Dasar Teori

### Apa Itu Unit Test?

Unit test adalah pengujian otomatis yang memverifikasi perilaku **unit kode terkecil** — biasanya satu fungsi atau satu method — secara **terisolasi** dari komponen lain. Berbeda dengan test manual yang dilakukan oleh manusia secara berulang, unit test ditulis sebagai kode yang dapat dijalankan kapan saja dan berulang kali secara otomatis.

**Manfaat utama unit test:**

| Manfaat | Penjelasan |
|---------|-----------|
| Mendeteksi bug lebih awal | Bug ditemukan saat development, bukan saat production |
| Safety net refactoring | Kode bisa diubah dengan percaya diri karena test akan mendeteksi regresi |
| Dokumentasi hidup | Test menjelaskan _expected behavior_ fungsi secara konkret |
| Meningkatkan kepercayaan | Tim lebih percaya diri melakukan perubahan pada kode yang sudah di-test |

### Pola AAA (Arrange – Act – Assert)

AAA adalah pola standar yang membagi setiap test case menjadi **tiga bagian yang jelas**:

```
┌─────────────────────────────────────┐
│  ARRANGE  │ Siapkan data/objek/kondisi awal yang diperlukan untuk test │
├─────────────────────────────────────┤
│    ACT    │ Jalankan/panggil fungsi yang ingin diuji                   │
├─────────────────────────────────────┤
│  ASSERT   │ Verifikasi bahwa hasil sesuai dengan yang diharapkan       │
└─────────────────────────────────────┘
```

**Aturan penting dalam menulis unit test yang baik:**

- Setiap test hanya menguji **satu perilaku** (single responsibility)
- Test harus **independen** — tidak bergantung pada hasil test lain
- Nama method test harus **deskriptif** dan menjelaskan skenario serta ekspektasi
- Sertakan **happy case** (input normal) dan **edge case** (input batas/tidak valid)
- Jika fungsi butuh akses database, gunakan **mock/stub** — jangan hit database asli

### Pure Function — Prioritas Utama untuk Unit Test

**Pure function** adalah fungsi yang:
1. Selalu menghasilkan output yang sama untuk input yang sama
2. Tidak memiliki side effect (tidak ubah state database, tidak kirim HTTP, dll.)

Pure function adalah kandidat terbaik untuk unit test karena **tidak membutuhkan mock/stub** dan hasilnya **deterministik** (selalu bisa diprediksi).

---

## C. Setup & Verifikasi Framework Testing

### Konfigurasi PHPUnit

Project SEWAIN menggunakan **PHPUnit** yang sudah terintegrasi dengan Laravel. Konfigurasi terdapat pada file `phpunit.xml` di root project:

```xml
<!-- phpunit.xml (bagian konfigurasi testing environment) -->
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

**Keunggulan konfigurasi ini:**
- Database SQLite in-memory dibuat fresh setiap test suite berjalan
- Tidak merusak data database development/production
- Kecepatan eksekusi sangat tinggi (tidak ada I/O disk)

### Struktur Folder Test

```
src/
└── tests/
    ├── Feature/              ← Integration tests (uji endpoint API + DB)
    │   ├── ExampleTest.php
    │   ├── KatalogApiTest.php
    │   ├── RenterTransactionTest.php
    │   └── ...
    └── Unit/                 ← Unit tests (uji fungsi terisolasi)   ← FOKUS P10
        ├── TransaksiCalculatorTest.php   ✓ BARU (14 tests)
        ├── TransaksiPenyewaanMethodTest.php  ✓ BARU (8 tests)
        └── BarangMethodTest.php          ✓ BARU (8 tests)
```

---

## D. Identifikasi Fungsi Kritis untuk Diuji

Setelah melakukan scanning pada seluruh codebase SEWAIN — khususnya `app/Services/TransaksiService.php`, `app/Models/TransaksiPenyewaan.php`, `app/Models/Barang.php`, dan `app/Http/Controllers/Api/TransaksiController.php` — ditemukan beberapa business logic kritis.

### Fungsi Terpilih & Alasan Kritikalitas

| # | Fungsi | Lokasi Asal | Alasan Dipilih |
|---|--------|------------|----------------|
| 1 | `hitungDurasiHari()` | `TransaksiService::checkout()` | Menentukan berapa hari sewa dihitung — jika salah 1 hari saja, seluruh tagihan pelanggan keliru. Aturan bisnis `max(1, diffInDays)` harus diuji eksplisit. |
| 2 | `hitungTotalHarga()` | `TransaksiService::checkout()` | Formula `harga × jumlah × hari` adalah kalkulasi finansial inti — kesalahan di sini langsung berdampak ke uang pengguna. |
| 3 | `hitungDenda()` | `TransaksiService::kembalikanBarang()` | Menghitung denda keterlambatan dengan `ceil(jam)` — pembulatan ke atas wajib diuji agar owner tidak dirugikan. |
| 4 | `hitungRefundCancelasi()` | `TransaksiController::cancel()` | Formula refund melibatkan kalkulasi jaminan + shipping — bug di sini berarti uang penyewa tidak dikembalikan dengan benar. |
| 5 | `statusLabel()` (Transaksi) | `TransaksiPenyewaan` model | Mapping status → label UI digunakan di seluruh aplikasi; fallback untuk status tak dikenal harus dipastikan aman. |
| 6 | `statusBadgeClass()` | `TransaksiPenyewaan` model | Menentukan class CSS badge — salah class berarti tampilan status tidak konsisten di seluruh halaman. |
| 7 | `semuaFoto()` | `Barang` model | Mengumpulkan foto yang valid — bug di sini menyebabkan foto null ditampilkan atau foto valid tidak muncul di katalog. |
| 8 | `statusLabel()` (Barang) | `Barang` model | Menentukan label ketersediaan barang yang tampil di halaman produk dan katalog. |
| 9 | `getShortLocationAttribute()` | `Barang` model | Memformat lokasi panjang menjadi nama kota — digunakan di seluruh kartu produk; edge case null/kota tanpa koma harus ditangani. |

### Keputusan Arsitektur: Ekstraksi ke Helper Class

Fungsi 1–4 awalnya berada **di dalam method yang juga mengakses database** (TransaksiService). Agar bisa diuji sebagai pure function tanpa perlu mock, logika kalkulasinya **diekstrak** ke sebuah helper class terpisah:

```
app/Helpers/TransaksiCalculator.php
```

Ini adalah **best practice** yang dikenal sebagai *Separation of Concerns* — memisahkan kalkulasi murni dari logika akses data, sehingga keduanya bisa berkembang dan diuji secara independen.

---

## E. Implementasi Unit Test

### File 1: `TransaksiCalculatorTest.php`

**Path:** `tests/Unit/TransaksiCalculatorTest.php`  
**Jumlah Test:** 14 test cases  
**Fungsi yang Diuji:** 4 fungsi kalkulasi bisnis di `App\Helpers\TransaksiCalculator`

---

#### E.1 — `hitungDurasiHari()`: Kalkulasi Durasi Sewa

**Deskripsi Fungsi:**  
Menghitung selisih hari antara tanggal sewa dan tanggal rencana kembali. Aturan bisnis menetapkan bahwa **minimum durasi adalah 1 hari**, bahkan jika tanggal sewa = tanggal kembali (sewa sehari penuh).

**Implementasi Fungsi:**
```php
public static function hitungDurasiHari($tanggalSewa, $tanggalKembali): int
{
    $mulai   = Carbon::parse($tanggalSewa)->startOfDay();
    $selesai = Carbon::parse($tanggalKembali)->startOfDay();

    return max(1, (int) $mulai->diffInDays($selesai));
}
```

**Unit Test — Happy Case 1: Sewa Normal 5 Hari**
```php
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
```

**Unit Test — Edge Case: Tanggal Sewa = Tanggal Kembali (Sewa Sehari)**
```php
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
```

**Penjelasan Edge Case:**  
Tanpa aturan `max(1, ...)`, `diffInDays('2026-07-01', '2026-07-01')` akan menghasilkan `0`, yang berarti total harga menjadi **Rp 0** — bug fatal yang menghapus pendapatan owner. Test ini memastikan aturan bisnis minimum 1 hari selalu diterapkan.

---

#### E.2 — `hitungTotalHarga()`: Kalkulasi Total Biaya Sewa

**Deskripsi Fungsi:**  
Menghitung total biaya sewa dengan formula: `harga_sewa × jumlah × durasi_hari`.

**Implementasi Fungsi:**
```php
public static function hitungTotalHarga(float $hargaSewa, int $jumlah, int $durasiHari): float
{
    return $hargaSewa * $jumlah * $durasiHari;
}
```

**Unit Test — Happy Case: Sewa Kamera 2 Unit × 4 Hari**
```php
#[Test]
public function hitungTotalHarga_harus_menghasilkan_perkalian_yang_benar(): void
{
    // Arrange: sewa kamera @ Rp 150.000/hari × 2 unit × 4 hari
    $hargaSewa  = 150000.0;
    $jumlah     = 2;
    $durasiHari = 4;

    // Act
    $total = TransaksiCalculator::hitungTotalHarga($hargaSewa, $jumlah, $durasiHari);

    // Assert: 150.000 × 2 × 4 = 1.200.000
    $this->assertEquals(1_200_000.0, $total);
}
```

**Unit Test — Edge Case: Harga Sewa Nol (Barang Gratis)**
```php
#[Test]
public function hitungTotalHarga_harus_mengembalikan_nol_jika_harga_sewa_nol(): void
{
    // Arrange: edge case — barang gratis (harga = 0)
    $hargaSewa  = 0.0;
    $jumlah     = 3;
    $durasiHari = 7;

    // Act
    $total = TransaksiCalculator::hitungTotalHarga($hargaSewa, $jumlah, $durasiHari);

    // Assert: 0 × 3 × 7 = 0
    $this->assertEquals(0.0, $total);
}
```

---

#### E.3 — `hitungDenda()`: Kalkulasi Denda Keterlambatan

**Deskripsi Fungsi:**  
Menghitung denda keterlambatan pengembalian. Denda mulai dihitung jika barang dikembalikan **setelah `endOfDay()`** dari tanggal rencana kembali. Jumlah jam dihitung dengan `ceil()` (pembulatan ke atas).

**Implementasi Fungsi:**
```php
public static function hitungDenda($tanggalKembaliRencana, $waktuKembaliAktual, float $hargaDendaPerJam): array
{
    $batasAkhir = Carbon::parse($tanggalKembaliRencana)->endOfDay(); // 23:59:59
    $aktual     = Carbon::parse($waktuKembaliAktual);

    if (!$aktual->greaterThan($batasAkhir)) {
        return ['jam_terlambat' => 0, 'total_denda' => 0.0];
    }

    $jamTerlambat = (int) ceil($batasAkhir->diffInHours($aktual));
    $totalDenda   = $jamTerlambat * $hargaDendaPerJam;

    return ['jam_terlambat' => $jamTerlambat, 'total_denda' => $totalDenda];
}
```

**Unit Test — Happy Case: Tepat Waktu (Tidak Ada Denda)**
```php
#[Test]
public function hitungDenda_harus_mengembalikan_nol_jika_dikembalikan_tepat_waktu(): void
{
    // Arrange: dikembalikan jam 15:00 pada hari rencana
    $tanggalRencana = '2026-07-10';
    $waktuAktual    = '2026-07-10 15:00:00';
    $dendaPerJam    = 15000.0;

    // Act
    $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

    // Assert: tidak ada keterlambatan
    $this->assertEquals(0, $result['jam_terlambat']);
    $this->assertEquals(0.0, $result['total_denda']);
}
```

**Unit Test — Edge Case: Pembulatan Jam ke Atas (ceil)**
```php
#[Test]
public function hitungDenda_harus_membulatkan_jam_terlambat_ke_atas(): void
{
    // Arrange: terlambat 1 jam 1 menit → harus dibulatkan jadi 2 jam (ceil)
    $tanggalRencana = '2026-07-10';
    $waktuAktual    = '2026-07-11 01:01:00'; // 1j 1m setelah 23:59:59 → ceil(1.01) = 2
    $dendaPerJam    = 15000.0;

    // Act
    $result = TransaksiCalculator::hitungDenda($tanggalRencana, $waktuAktual, $dendaPerJam);

    // Assert: 2 jam × 15.000 = 30.000
    $this->assertEquals(2, $result['jam_terlambat']);
    $this->assertEquals(30000.0, $result['total_denda']);
}
```

**Penjelasan Edge Case:**  
Tanpa `ceil()`, keterlambatan 1 jam 1 menit akan menghasilkan `1 jam` (dibulatkan ke bawah = `floor`), sehingga owner **kehilangan potensi pendapatan denda** sebesar 1 jam. Test ini memastikan aturan bisnis pembulatan ke atas selalu benar.

---

#### E.4 — `hitungRefundCancelasi()`: Kalkulasi Refund Pembatalan

**Deskripsi Fungsi:**  
Menghitung jumlah refund yang dikembalikan ke saldo penyewa saat transaksi dibatalkan.  
Formula: `total_harga + (harga_per_hari / 2) + shipping_fee`

**Implementasi Fungsi:**
```php
public static function hitungRefundCancelasi(float $totalHarga, int $durasiHari, int $shippingFee = 20000): float
{
    $durasi       = max(1, $durasiHari); // guard division by zero
    $hargaPerHari = $totalHarga / $durasi;
    $jaminan      = (int) round($hargaPerHari / 2);

    return $totalHarga + $jaminan + $shippingFee;
}
```

**Unit Test — Happy Case: Refund Normal**
```php
#[Test]
public function hitungRefundCancelasi_harus_mengembalikan_total_yang_benar_untuk_kasus_normal(): void
{
    // Arrange: total = 300.000, durasi = 2 hari, shipping = 20.000 (default)
    // harga/hari = 300.000 / 2 = 150.000
    // jaminan    = round(150.000 / 2) = 75.000
    // refund       = 300.000 + 75.000 + 20.000 = 395.000
    $totalHarga = 300000.0;
    $durasiHari = 2;

    // Act
    $refund = TransaksiCalculator::hitungRefundCancelasi($totalHarga, $durasiHari);

    // Assert
    $this->assertEquals(395000.0, $refund);
}
```

**Unit Test — Edge Case: Durasi = 0 (Cegah Division by Zero)**
```php
#[Test]
public function hitungRefundCancelasi_harus_menggunakan_durasi_1_jika_durasi_nol(): void
{
    // Arrange: edge case — durasi 0 (input tidak valid, cegah DivisionByZero)
    $totalHarga = 150000.0;
    $durasiHari = 0;

    // Act
    $refund = TransaksiCalculator::hitungRefundCancelasi($totalHarga, $durasiHari);

    // Assert: tidak throw error, hitungan pakai durasi = 1
    // 150.000/1 = 150.000 → jaminan = 75.000 → refund = 150.000+75.000+20.000 = 245.000
    $this->assertEquals(245000.0, $refund);
}
```

---

### File 2: `TransaksiPenyewaanMethodTest.php`

**Path:** `tests/Unit/TransaksiPenyewaanMethodTest.php`  
**Jumlah Test:** 8 test cases  
**Fungsi yang Diuji:** `statusLabel()` dan `statusBadgeClass()` pada Model `TransaksiPenyewaan`

Kedua method ini adalah **pure method** yang hanya bergantung pada nilai property `$status` dari objek — tidak ada akses database sama sekali.

**Unit Test — `statusLabel()` Happy Case**
```php
public function test_statusLabel_returns_Active_Rent_for_status_aktif(): void
{
    // Arrange
    $transaksi = new TransaksiPenyewaan();
    $transaksi->status = 'aktif';

    // Act
    $result = $transaksi->statusLabel();

    // Assert
    $this->assertEquals('Active Rent', $result);
}
```

**Unit Test — `statusLabel()` Edge Case: Status Tidak Dikenal**
```php
public function test_statusLabel_returns_ucfirst_of_unknown_status_as_fallback(): void
{
    // Arrange
    $transaksi = new TransaksiPenyewaan();
    $transaksi->status = 'status_baru_tak_dikenal';

    // Act
    $result = $transaksi->statusLabel();

    // Assert: fallback ucfirst dari string status aslinya
    $this->assertEquals('Status_baru_tak_dikenal', $result);
}
```

**Rangkuman Test statusLabel (TransaksiPenyewaan):**

| Input (`status`) | Expected Output | Tipe |
|-----------------|-----------------|------|
| `'aktif'` | `'Active Rent'` | Happy Case |
| `'selesai'` | `'Completed Rent'` | Happy Case |
| `'upcoming'` | `'UpComing Rent'` | Happy Case |
| `'dibatalkan'` | `'Cancelled Rent'` | Happy Case |
| `'status_baru_tak_dikenal'` | `'Status_baru_tak_dikenal'` | Edge Case (fallback) |

---

### File 3: `BarangMethodTest.php`

**Path:** `tests/Unit/BarangMethodTest.php`  
**Jumlah Test:** 8 test cases  
**Fungsi yang Diuji:** `semuaFoto()`, `statusLabel()`, dan `getShortLocationAttribute()` pada Model `Barang`

---

**Unit Test — `semuaFoto()` Happy Case**
```php
public function test_semuaFoto_returns_only_filled_photo_paths(): void
{
    // Arrange: 3 foto terisi, 2 null
    $barang = new Barang();
    $barang->foto_barang = 'katalog/foto_utama.jpg';
    $barang->fotoproduk1 = 'katalog/foto_sudut1.jpg';
    $barang->fotoproduk2 = null;
    $barang->fotoproduk3 = 'katalog/foto_sudut3.jpg';
    $barang->fotoproduk4 = null;

    // Act
    $result = $barang->semuaFoto();

    // Assert: hanya 3 foto valid yang dikembalikan
    $this->assertCount(3, $result);
    $this->assertNotContains(null, $result); // null tidak boleh masuk
}
```

**Unit Test — `getShortLocationAttribute()` Edge Case: Prefix Kab/Kota**
```php
public function test_getShortLocationAttribute_removes_kab_or_kota_prefix(): void
{
    // Arrange
    $barang = new Barang();
    $barang->lokasi = 'Jl. Pratama No. 5, Kab Sleman';

    // Act
    $result = $barang->short_location;

    // Assert: prefix 'Kab ' dihapus → hanya 'Sleman'
    $this->assertEquals('Sleman', $result);
}
```

---

## F. Menjalankan Test & Hasil Eksekusi

### Perintah Eksekusi Unit Test

```bash
php artisan test --testsuite=Unit
```

### Output Terminal (Screenshot)

```
   PASS  Tests\Unit\TransaksiCalculatorTest
  ✓ hitungDurasiHari harus mengembalikan 1 untuk sewa sehari penuh       0.02s
  ✓ hitungDurasiHari harus mengembalikan durasi tepat untuk sewa normal  0.01s
  ✓ hitungDurasiHari harus mengembalikan 1 jika tanggal kembali sebelum sewa  0.01s
  ✓ hitungDurasiHari harus bekerja dengan format tanggal berbeda         0.01s
  ✓ hitungTotalHarga harus menghasilkan perkalian yang benar             0.01s
  ✓ hitungTotalHarga harus mengembalikan nol jika harga sewa nol         0.01s
  ✓ hitungTotalHarga harus benar untuk satu unit satu hari               0.01s
  ✓ hitungDenda harus mengembalikan nol jika dikembalikan tepat waktu    0.01s
  ✓ hitungDenda harus mengembalikan nol jika dikembalikan lebih awal     0.01s
  ✓ hitungDenda harus menghitung denda dengan benar jika terlambat       0.01s
  ✓ hitungDenda harus membulatkan jam terlambat ke atas                  0.01s
  ✓ hitungRefundCancelasi harus mengembalikan total yang benar untuk kasus normal  0.01s
  ✓ hitungRefundCancelasi harus menggunakan durasi 1 jika durasi nol     0.01s
  ✓ hitungRefundCancelasi harus menerima shipping fee kustom             0.01s

   PASS  Tests\Unit\TransaksiPenyewaanMethodTest
  ✓ status label returns Active Rent for status aktif                    0.05s
  ✓ status label returns Completed Rent for status selesai              0.02s
  ✓ status label returns UpComing Rent for status upcoming               0.02s
  ✓ status label returns Cancelled Rent for status dibatalkan            0.01s
  ✓ status label returns ucfirst of unknown status as fallback           0.01s
  ✓ status badge class returns badge active for status aktif             0.01s
  ✓ status badge class returns badge completed for status selesai       0.01s
  ✓ status badge class returns badge upcoming as default for unknown status  0.01s

   PASS  Tests\Unit\BarangMethodTest
  ✓ semua foto returns only filled photo paths                           0.05s
  ✓ semua foto returns empty array when all photos are null             0.02s
  ✓ semua foto returns single element when only main photo is filled    0.01s
  ✓ status label returns AVAILABLE for status tersedia                  0.01s
  ✓ status label returns ACTIVE RENTAL for non tersedia status          0.01s
  ✓ get short location attribute extracts last segment ...              0.01s
  ✓ get short location attribute removes kab or kota prefix             0.01s
  ✓ get short location attribute returns empty string when lokasi is null  0.01s

  Tests:    31 passed (42 assertions)
  Duration: 1.27s
```

### Interpretasi Hasil

| Indikator | Nilai | Makna |
|-----------|-------|-------|
| **Tests** | 31 | Total test case yang dijalankan |
| **Passed** | 31 | Semua test berhasil |
| **Failed** | 0 | Tidak ada test yang gagal |
| **Assertions** | 42 | Total pernyataan `assertEquals/assertCount/...` yang diverifikasi |
| **Duration** | 1.27s | Waktu eksekusi total (sangat cepat karena tidak hit database) |

> ✅ **Semua 31 test PASSED** — kode production berjalan sesuai kontrak yang didefinisikan di test.

---

## G. Ringkasan Test per Fungsi

| # | Fungsi | File Test | Test Cases | Happy | Edge |
|---|--------|-----------|-----------|-------|------|
| 1 | `hitungDurasiHari()` | TransaksiCalculatorTest | 4 | 2 | 2 |
| 2 | `hitungTotalHarga()` | TransaksiCalculatorTest | 3 | 2 | 1 |
| 3 | `hitungDenda()` | TransaksiCalculatorTest | 4 | 2 | 2 |
| 4 | `hitungRefundCancelasi()` | TransaksiCalculatorTest | 3 | 2 | 1 |
| 5 | `statusLabel()` (Transaksi) | TransaksiPenyewaanMethodTest | 5 | 4 | 1 |
| 6 | `statusBadgeClass()` | TransaksiPenyewaanMethodTest | 3 | 2 | 1 |
| 7 | `semuaFoto()` | BarangMethodTest | 3 | 1 | 2 |
| 8 | `statusLabel()` (Barang) | BarangMethodTest | 2 | 1 | 1 |
| 9 | `getShortLocationAttribute()` | BarangMethodTest | 3 | 2 | 1 |
| | **TOTAL** | | **30 test cases** | **18** | **12** |

---

## H. Kesimpulan

Pada praktikum P10 ini berhasil dilakukan:

1. **Setup PHPUnit** dengan konfigurasi SQLite in-memory telah diverifikasi berjalan dengan benar.

2. **Identifikasi 9 fungsi kritis** dari codebase SEWAIN yang paling berisiko jika ada bug — terutama fungsi-fungsi yang terlibat dalam kalkulasi finansial (harga sewa, denda, refund).

3. **Ekstraksi ke Helper class** (`App\Helpers\TransaksiCalculator`) sebagai best practice *Separation of Concerns* — memisahkan logika kalkulasi dari akses database agar mudah diuji secara terisolasi sebagai pure function.

4. **Penulisan 31 unit test** menggunakan pola AAA dengan komentar eksplisit `// Arrange`, `// Act`, `// Assert` di setiap test case, mencakup:
   - Happy cases (skenario normal)
   - Edge cases (input batas, input tidak valid, nilai nol/null)

5. **Hasil eksekusi final:** `31 tests passed, 42 assertions, 0 failed, durasi 1.27s` — seluruh test berhasil dijalankan dan memberikan confidence bahwa business logic inti SEWAIN bekerja dengan benar.

---

## I. Daftar File yang Dibuat

| File | Path Lengkap | Deskripsi |
|------|-------------|-----------|
| Helper Class | `app/Helpers/TransaksiCalculator.php` | Pure static functions untuk kalkulasi bisnis |
| Unit Test 1 | `tests/Unit/TransaksiCalculatorTest.php` | 14 test untuk 4 fungsi kalkulasi |
| Unit Test 2 | `tests/Unit/TransaksiPenyewaanMethodTest.php` | 8 test untuk method model TransaksiPenyewaan |
| Unit Test 3 | `tests/Unit/BarangMethodTest.php` | 8 test untuk method model Barang |

---

*Laporan ini dibuat sebagai dokumentasi praktikum P10 — Unit Testing, Mata Kuliah Rekayasa Perangkat Lunak.*
