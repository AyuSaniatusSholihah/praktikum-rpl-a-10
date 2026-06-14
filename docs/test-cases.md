# Dokumen Pengujian Manual (Manual Test Cases)

Dokumen ini berisi sekumpulan test case pengujian manual untuk fitur-fitur MVP pada aplikasi **SEWAIN**. Pengujian ini mencakup skenario berhasil (*Happy Path*) dan skenario gagal (*Unhappy Path*).

## 1. Fitur Autentikasi (Registrasi & Login)

| Test ID | Skenario Pengujian | Langkah-Langkah (Steps) | Expected Result | Actual Result | Status | Screenshot (Bukti) |
|---|---|---|---|---|---|---|
| TC-01 | **[Happy Path]** Registrasi pengguna baru dengan data valid | 1. Buka halaman Register<br>2. Isi nama, email, password, dan konfirmasi password<br>3. Klik tombol Daftar | Akun berhasil dibuat dan pengguna diarahkan ke halaman verifikasi/dashboard. | Akun berhasil terdaftar dan masuk ke dashboard. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-02 | **[Unhappy Path]** Registrasi dengan email yang sudah terdaftar | 1. Buka halaman Register<br>2. Isi data dengan email yang sudah terdaftar<br>3. Klik tombol Daftar | Sistem menolak pendaftaran dan menampilkan pesan error "Email sudah digunakan". | Muncul pesan error validasi email sudah digunakan. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-03 | **[Happy Path]** Login dengan kredensial yang benar | 1. Buka halaman Login<br>2. Masukkan email dan password yang valid<br>3. Klik tombol Masuk | Pengguna berhasil masuk dan diarahkan ke Dashboard sesuai rolenya. | Berhasil login dan masuk ke Dashboard. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-04 | **[Unhappy Path]** Login dengan password salah | 1. Buka halaman Login<br>2. Masukkan email valid dan password yang salah<br>3. Klik tombol Masuk | Sistem menampilkan pesan error "Kredensial tidak valid" dan tidak mengizinkan masuk. | Muncul error bahwa email atau password salah. | ✅ Pass | `<-- isi link gambar di sini -->` |

## 2. Fitur Katalog Barang (Owner)

| Test ID | Skenario Pengujian | Langkah-Langkah (Steps) | Expected Result | Actual Result | Status | Screenshot (Bukti) |
|---|---|---|---|---|---|---|
| TC-05 | **[Happy Path]** Menambah barang baru dengan data lengkap | 1. Login sebagai Owner<br>2. Buka menu Tambah Barang<br>3. Isi form (nama, kategori, harga, foto)<br>4. Klik Simpan | Barang berhasil disimpan dan muncul di daftar katalog Owner. | Barang baru berhasil ditambahkan dan terlihat di daftar barang. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-06 | **[Unhappy Path]** Menambah barang dengan form tidak lengkap | 1. Login sebagai Owner<br>2. Buka menu Tambah Barang<br>3. Kosongkan field foto barang atau harga<br>4. Klik Simpan | Sistem mencegah form dikirim dan menampilkan pesan peringatan (validasi wajib diisi). | Form tidak tersubmit, muncul peringatan "Field harus diisi". | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-07 | **[Happy Path]** Mengedit informasi barang | 1. Login sebagai Owner<br>2. Buka Katalog Barang<br>3. Klik Edit pada salah satu barang<br>4. Ubah harga/deskripsi dan Simpan | Data barang berhasil diperbarui di database dan tampilan berubah. | Perubahan tersimpan dengan sukses dan data terupdate. | ✅ Pass | `<-- isi link gambar di sini -->` |

## 3. Fitur Penyewaan Barang & Transaksi

| Test ID | Skenario Pengujian | Langkah-Langkah (Steps) | Expected Result | Actual Result | Status | Screenshot (Bukti) |
|---|---|---|---|---|---|---|
| TC-08 | **[Happy Path]** Pencarian dan filter barang | 1. Login sebagai Penyewa<br>2. Masukkan kata kunci pada kotak pencarian<br>3. Pilih kategori/filter harga<br>4. Klik Cari | Halaman menampilkan daftar barang yang sesuai dengan kriteria filter/pencarian. | Daftar barang ter-filter sesuai kata kunci dan rentang harga. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-09 | **[Happy Path]** Proses checkout penyewaan barang | 1. Login sebagai Penyewa<br>2. Pilih barang yang ingin disewa<br>3. Tentukan tanggal mulai dan selesai<br>4. Klik Sewa/Checkout | Barang masuk ke keranjang/pesanan dibuat dan status pesanan menjadi 'Menunggu Pembayaran' atau 'Menunggu Konfirmasi'. | Pesanan berhasil dibuat dan tercatat di riwayat sewa. | ✅ Pass | `<-- isi link gambar di sini -->` |
| TC-10 | **[Unhappy Path]** Menyewa di tanggal yang tidak tersedia/overlap | 1. Login sebagai Penyewa<br>2. Pilih barang yang sudah disewa orang lain pada tanggal X<br>3. Pilih tanggal X di form sewa | Sistem mendisable tanggal X atau menampilkan error bahwa barang tidak tersedia pada tanggal tersebut. | Tanggal tidak bisa dipilih atau muncul error barang sudah disewa. | ✅ Pass | `<-- isi link gambar di sini -->` |
