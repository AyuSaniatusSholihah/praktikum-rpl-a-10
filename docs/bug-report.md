# 🐛 Bug Report — SEWAIN Platform Penyewaan Barang

**Kelompok:** SewaDev (A-10)
**Repositori:** https://github.com/AyuSaniatusSholihah/praktikum-rpl-a-10

---

## Ringkasan Bug

| ID | Judul | Modul | Severity | Status |
|----|-------|-------|----------|--------|
| [BUG-01](#bug-01--otp-tidak-memvalidasi-waktu-kadaluarsa) | OTP tidak memvalidasi waktu kadaluarsa | Autentikasi | 🔴 High | 🔵 Open |
| [BUG-02](#bug-02--tidak-ada-validasi-overlap-tanggal-sewa-double-booking) | Tidak ada validasi overlap tanggal sewa (Double Booking) | Transaksi | 🔴 High | 🔵 Open |
| [BUG-04](#bug-04--stok-barang-tidak-dikembalikan-setelah-verifikasi-pengembalian) | Stok barang tidak dikembalikan setelah verifikasi pengembalian | Pengembalian | 🔴 High | ✅ Fixed |

---

## BUG-01 — OTP Tidak Memvalidasi Waktu Kadaluarsa

### 📋 Informasi Bug

| Field | Detail |
|-------|--------|
| **ID** | BUG-01 |
| **Modul** | Autentikasi — Verifikasi OTP |
| **Severity** | 🔴 High (Celah keamanan kritis pada fitur Autentikasi) |
| **Status** | 🔵 Open |
| **Ditemukan oleh** | Tim SewaDev |

### 🔍 Deskripsi Masalah

Sistem tidak memeriksa batas waktu masa aktif kode OTP. Akibatnya, pengguna yang memasukkan kode OTP yang sudah usang/expired tetap lolos verifikasi dan dapat melanjutkan ke halaman ganti password baru.

Ini merupakan **celah keamanan serius** karena OTP yang seharusnya tidak berlaku lagi masih diterima oleh sistem, sehingga potensi penyalahgunaan oleh pihak tidak bertanggung jawab menjadi tinggi.

### 🔁 Langkah Reproduksi

1. Buka halaman verifikasi OTP (misalnya, setelah meminta reset password).
2. Tunggu lebih dari **10 menit** agar OTP kedaluwarsa.
3. Masukkan kode OTP lama tersebut ke form verifikasi, lalu klik **Verifikasi**.

### ✅ Perilaku yang Diharapkan

Sistem menolak kode OTP yang sudah melewati batas waktu berlaku (expired) dan menampilkan pesan:
> *"Kode OTP tidak valid atau telah kedaluwarsa. Silakan minta kode baru."*

### ❌ Perilaku yang Terjadi

Sistem menerima kode OTP lama (expired) dan mengarahkan pengguna ke halaman berikutnya seolah verifikasi berhasil.

### 🛠️ Analisis Penyebab

Validasi pada controller verifikasi OTP tidak menyertakan pengecekan kolom `expired_at` atau `created_at` pada tabel `otps`. Sistem hanya memverifikasi kecocokan kode OTP (string matching) tanpa memeriksa batas waktu berlakunya.

```php
// ❌ Kondisi yang menyebabkan bug (hanya cek kode, tanpa cek waktu):
$otp = Otp::where('kode', $request->kode)->first();

// ✅ Seharusnya:
$otp = Otp::where('kode', $request->kode)
           ->where('expired_at', '>', now())
           ->whereNull('used_at')
           ->first();
```

### 📌 Rekomendasi Perbaikan

- Tambahkan pengecekan `expired_at > now()` pada query pencarian OTP.
- Tambahkan kolom `used_at` untuk menandai OTP yang sudah terpakai agar tidak bisa digunakan ulang.
- Tetapkan masa berlaku OTP maksimal **15 menit** sejak dibuat.

---

## BUG-02 — Tidak Ada Validasi Overlap Tanggal Sewa (Double Booking)

### 📋 Informasi Bug

| Field | Detail |
|-------|--------|
| **ID** | BUG-02 |
| **Modul** | Transaksi — Checkout & Keranjang |
| **Severity** | 🔴 High (Bug logika bisnis inti yang merusak integritas data transaksi dan ketersediaan jadwal barang) |
| **Status** | 🔵 Open |
| **Ditemukan oleh** | Tim SewaDev |

### 🔍 Deskripsi Masalah

Terdapat kerusakan logika backend pada sistem transaksi. Aplikasi mengurangi jumlah stok secara instan/global di database **tanpa melakukan validasi berbasis rentang tanggal** (*schedule-based validation*). Hal ini menyebabkan dua masalah kritis:

1. **Double Booking**: Dua penyewa dapat menyewa barang yang sama di tanggal yang saling bertabrakan (*overlap*), selama stok global di database masih bernilai lebih dari 0.
2. **Salah Blokir Tanggal Aman**: Penyewa lain ditolak menyewa di tanggal yang sama sekali tidak bertabrakan, karena stok global di database sudah dikurangi oleh transaksi penyewa sebelumnya.

### 🔁 Langkah Reproduksi

1. Penyewa A menyewa **Tenda X** untuk tanggal **1–5 Juli 2026** dan menyelesaikan pembayaran.
2. Penyewa B masuk menggunakan akun lain, membuka produk **Tenda X**, lalu memilih rentang tanggal sewa yang **bertabrakan (overlap)**: **3–6 Juli 2026**.
3. Penyewa B klik **Tambah ke Keranjang** dan berhasil melakukan checkout **tanpa ada penolakan dari sistem**.

### ✅ Perilaku yang Diharapkan

Saat Penyewa B memilih tanggal 3–6 Juli 2026, sistem seharusnya memeriksa apakah barang tersebut sudah dalam transaksi aktif pada rentang tanggal tersebut, dan menampilkan pesan:
> *"Barang tidak tersedia pada tanggal yang dipilih. Silakan pilih tanggal lain."*

### ❌ Perilaku yang Terjadi

Sistem mengizinkan Penyewa B melakukan checkout meskipun tanggal yang dipilih bertabrakan dengan transaksi aktif Penyewa A. Tidak ada validasi rentang tanggal yang dilakukan.

### 🛠️ Analisis Penyebab

Logika checkout hanya memeriksa nilai `stok` global pada tabel `barangs` (apakah `stok > 0`), tanpa melakukan join atau subquery ke tabel `transaksi_penyewaans` untuk mengecek apakah barang tersebut sudah memiliki transaksi aktif yang tumpang tindih pada rentang tanggal yang diinginkan.

```php
// ❌ Kondisi yang menyebabkan bug (hanya cek stok global):
if ($barang->stok < $request->jumlah) {
    return response()->json(['message' => 'Stok tidak mencukupi'], 422);
}

// ✅ Seharusnya ditambahkan validasi overlap tanggal:
$overlap = TransaksiPenyewaan::where('barang_id', $barang->id)
    ->whereIn('status', ['aktif', 'menunggu_pembayaran'])
    ->where(function ($query) use ($request) {
        $query->whereBetween('tanggal_sewa', [$request->tanggal_sewa, $request->tanggal_kembali_rencana])
              ->orWhereBetween('tanggal_kembali_rencana', [$request->tanggal_sewa, $request->tanggal_kembali_rencana]);
    })->exists();

if ($overlap) {
    return response()->json(['message' => 'Barang tidak tersedia pada tanggal yang dipilih'], 422);
}
```

### 📌 Rekomendasi Perbaikan

- Implementasikan validasi *schedule-based* pada controller checkout dengan query overlap tanggal.
- Tambahkan index pada kolom `tanggal_sewa` dan `tanggal_kembali_rencana` di tabel `transaksi_penyewaans` untuk performa query.
- Pertimbangkan penggunaan **Pessimistic Locking** (`lockForUpdate()`) dalam `DB::transaction()` untuk menghindari race condition saat checkout bersamaan.

---

## BUG-04 — Stok Barang Tidak Dikembalikan Setelah Verifikasi Pengembalian

### 📋 Informasi Bug

| Field | Detail |
|-------|--------|
| **ID** | BUG-04 |
| **Modul** | Pengembalian Barang — Owner Dashboard |
| **File Terdampak** | `src/app/Http/Controllers/ProfileController.php` |
| **Fungsi Terdampak** | `acceptPengembalian()` |
| **Severity** | 🔴 High (Bug logika inti yang merusak perputaran stok barang di platform) |
| **Status** | ✅ Fixed — Diperbaiki di branch `bug` |

### 🔍 Deskripsi Masalah

Terdapat kesalahan logika backend pada fungsi `acceptPengembalian()` di `ProfileController.php`. Saat owner menyetujui pengembalian barang, sistem hanya mengubah **status barang** menjadi `'tersedia'`, tetapi **lupa menambah kembali kuantitas stok** berdasarkan jumlah unit yang disewa (`$trx->jumlah`). Akibatnya, stok berkurang secara permanen dan penyewa lain tidak dapat melakukan transaksi berikutnya.

### 🔁 Langkah Reproduksi

1. Login sebagai **Owner**, periksa stok awal **Barang X** (contoh: stok = **3**).
2. Terima pengembalian barang dari transaksi penyewa yang meminjam **1 unit** Barang X dengan mengklik tombol **Accept Pengembalian**.
3. Periksa kembali katalog barang milik Owner maupun halaman publik.

### ✅ Perilaku yang Diharapkan

Setelah owner menerima pengembalian 1 unit, stok Barang X seharusnya bertambah kembali:
> Stok semula **2** → setelah Accept Pengembalian → menjadi **3**.

### ❌ Perilaku yang Terjadi

Status barang berubah menjadi `tersedia`, namun **jumlah stok tidak bertambah kembali** menjadi 3 — tetap tertahan di angka **2**.

### 🛠️ Analisis Penyebab

```php
// ❌ Kode sebelum perbaikan (lupa increment stok):
public function acceptPengembalian($id) {
    $trx = TransaksiPenyewaan::findOrFail($id);
    $trx->update(['status' => 'selesai']);
    $trx->barang->update(['status' => 'tersedia']); // ← stok tidak dikembalikan!
}

// ✅ Kode setelah perbaikan:
public function acceptPengembalian($id) {
    $trx = TransaksiPenyewaan::findOrFail($id);
    $trx->update(['status' => 'selesai']);
    $trx->barang->update(['status' => 'tersedia']);
    $trx->barang->increment('stok', $trx->jumlah); // ← stok dikembalikan sesuai jumlah
}
```

### ✅ Bukti Perbaikan

- **Branch perbaikan:** `bug`
- **Hasil setelah fix:** Stok yang awalnya tidak bertambah, kini bertambah kembali sebesar jumlah unit yang dikembalikan.
- **Dicatat dalam CHANGELOG:** `v1.0.0` — *"Memperbaiki BUG-04: Mengembalikan stok barang saat owner memberikan konfirmasi pengembalian barang"*

---

*Dokumen ini disusun oleh Tim SewaDev — Kelompok A-10, Rekayasa Perangkat Lunak, Universitas Sebelas Maret 2025/2026.*
