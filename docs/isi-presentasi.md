# Isi Lengkap Presentasi Proyek RPL (Kelompok A-10)

Berikut adalah konten *copy-paste* untuk isi (teks) di dalam slide PowerPoint/Canva beserta saran ucapan (Speaker Notes) saat presentasi.

---

## SLIDE 1: Cover / Judul
**Teks di Slide:**
- **Judul:** SEWAIN - Platform Sistem Informasi Penyewaan Barang Terintegrasi
- **Sub-judul:** Proyek Mata Kuliah Rekayasa Perangkat Lunak
- **Tim Pengembang (Kelompok A-10):**
  - APRILIA ALFA GUSASTI CIPTANINGTYAS (L0124003)
  - AYU SANIATUS SHOLIHAH (L0124005)
  - GHAZI FAHMI RAMADHAN (L0124130)

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Halo semuanya, selamat [pagi/siang]. Kami dari Kelompok A-10 akan mempresentasikan hasil proyek Rekayasa Perangkat Lunak kami yang bernama SEWAIN, yaitu sebuah platform sistem informasi penyewaan barang terintegrasi."

---

## SLIDE 2: Latar Belakang & Problem Statement
**Teks di Slide:**
**Masalah Saat Ini:**
- Proses sewa manual (hanya via *chat/WhatsApp*).
- Informasi ketersediaan barang dan jadwal sewa tidak jelas.
- Rawan miskomunikasi dan penipuan.

**Peluang:**
- Banyak masyarakat memiliki barang yang jarang dipakai dan berpotensi menjadi sumber penghasilan tambahan.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Proyek ini berawal dari keresahan kami melihat proses penyewaan barang yang masih sangat manual, biasanya hanya lewat WhatsApp. Akibatnya, informasi barang sering tidak jelas, jadwalnya bentrok, dan rentan miskomunikasi antara penyewa dan pemilik barang. Padahal, banyak orang di luar sana punya barang nganggur yang bisa disewakan untuk tambahan penghasilan. Dari sinilah kami melihat peluang."

---

## SLIDE 3: Solusi yang Ditawarkan
**Teks di Slide:**
**Solusi: SEWAIN**
Platform digital yang mempertemukan penyewa dan pemilik barang (*Owner*).

**Nilai Tambah (Value):**
1. **Sentralisasi:** Katalog barang, jadwal, dan harga ada di satu tempat.
2. **Terstruktur:** Alur *checkout*, pembayaran, hingga pengembalian sistematis.
3. **Aman & Transparan:** Terdapat riwayat transaksi dan pengawasan *Admin*.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Untuk memecahkan masalah tersebut, kami membangun SEWAIN. Aplikasi ini mempertemukan penyewa dan pemilik barang dalam satu platform digital. Nilai tambah aplikasi ini adalah memusatkan semua katalog, membuat transaksi menjadi terstruktur seperti e-commerce pada umumnya, dan tentunya jauh lebih aman karena ada sistem riwayat dan moderasi."

---

## SLIDE 4: Analisis Kebutuhan (User Stories & Aktor)
**Teks di Slide:**
*(Tambahkan Gambar Use Case Diagram di sebelah teks)*
**3 Aktor Utama Sistem:**
- 🧑 **Penyewa:** Mencari barang $\rightarrow$ Add to Cart $\rightarrow$ Checkout $\rightarrow$ Bayar $\rightarrow$ Beri Ulasan.
- 💼 **Owner (Pemilik Barang):** Tambah katalog barang $\rightarrow$ Setujui pesanan $\rightarrow$ Pantau status penyewaan.
- 🛡️ **Admin:** Pantau aktivitas $\rightarrow$ Kelola user $\rightarrow$ Tindak akun bermasalah (Ban/Freeze).

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Sebelum coding, kami melakukan analisis kebutuhan menggunakan User Stories yang kemudian kami terjemahkan ke Use Case Diagram. Seperti yang terlihat, ada 3 aktor utama: Penyewa, Owner, dan Admin. Masing-masing memiliki hak akses dan alur kerja (flow) yang berbeda di dalam sistem agar platform tetap seimbang dan aman."

---

## SLIDE 5: Alur Kerja Sistem (Activity Diagram)
**Teks di Slide:**
*(Tambahkan Gambar Activity Diagram Proses Sewa)*
**Alur Sewa Barang:**
1. Pilih barang & masukkan Keranjang
2. Checkout & isi detail pengiriman
3. **Verifikasi Owner** (Setuju/Tolak)
4. Pembayaran oleh Penyewa
5. Penggunaan $\rightarrow$ Pengembalian & Ulasan

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Dari sisi alur bisnis, kami merancang Activity Diagram yang ketat. Salah satu poin pentingnya ada di tahap verifikasi. Setelah penyewa melakukan checkout, Owner harus menyetujui dulu pesanannya sebelum penyewa bisa membayar. Hal ini mencegah barang di-booking (dipesan) pada jadwal yang tidak memungkinkan bagi si pemilik barang."

---

## SLIDE 6: Perancangan Basis Data (ERD)
**Teks di Slide:**
*(Tambahkan cuplikan gambar ERD)*
**Struktur Database Relasional:**
- Dirancang untuk skalabilitas dan integritas data.
- Tabel Inti: `users`, `barangs`, `orders`, `transaksi_penyewaans`.
- Fitur pendukung dicatat di: `keranjangs`, `reviews`, dan `activity_logs`.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Untuk mendukung alur yang kompleks tadi, kami merancang database relasional yang kami wujudkan dalam Entity Relationship Diagram (ERD). Kami memisahkan tabel *orders* dan *transaksi* untuk membedakan antara pesanan keranjang secara keseluruhan dengan transaksi barang individual. Semuanya saling terelasi untuk menjaga konsistensi data."

---

## SLIDE 7: Fitur Utama Aplikasi (Implementasi)
**Teks di Slide:**
*(Gunakan icon-icon menarik untuk list ini)*
1. 🔐 **Keamanan & Login:** Verifikasi OTP dan Google OAuth (Login with Google).
2. 🛒 **Katalog & Keranjang:** Filter barang dan *Checkout* multi-barang.
3. 💳 **Transaksi Terpadu:** Sistem dompet (*My Wallet*) & pencatatan metode pengiriman.
4. 📊 **Dashboard Spesifik:** Panel *Monitoring* Admin, Manajemen *Item* Owner, dan Riwayat Sewa Penyewa.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Dari seluruh rancangan tersebut, kami berhasil mengimplementasikan fitur-fitur utama. Autentikasi kami buat aman dengan OTP dan Google Login. Fitur transaksinya juga sudah mendukung keranjang (cart) dan checkout multi-barang. Kami juga membuat dashboard yang menyesuaikan role penggunanya, apakah dia Admin, Owner, atau Penyewa."

---

## SLIDE 8: Desain vs Implementasi (Wireframe & Hasil Akhir)
**Teks di Slide:**
*(Bagi slide menjadi 2 kolom: Kiri gambar Wireframe awal, Kanan screenshot Website aslinya)*
- **Desain Awal (Wireframe):** Konsep tata letak UI/UX.
- **Implementasi (Laravel + CSS):** Hasil *coding* antarmuka yang responsif dan interaktif.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Berikut adalah perbandingan antara rancangan UI/UX (Wireframe) yang kami buat di awal, dengan hasil akhir website yang sudah kami kembangkan menggunakan framework Laravel. (Bila ada live demo, silakan demokan fitur checkout atau login di sini)."

---

## SLIDE 9: Kesimpulan
**Teks di Slide:**
- **Pencapaian:** SEWAIN berhasil mendigitalisasi proses penyewaan manual menjadi sistem yang terstruktur, transparan, dan aman.
- **Nilai Tambah:** Memaksimalkan utilitas barang *nganggur* menjadi sumber penghasilan.
- **Harapan ke Depan:** Integrasi *payment gateway* (pihak ketiga) dan sistem notifikasi *real-time*.

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Sebagai kesimpulan, aplikasi SEWAIN ini sukses mendigitalisasi penyewaan yang dulunya manual. Tidak hanya mempermudah penyewa, tapi juga memberdayakan pemilik barang. Ke depannya, sistem ini masih bisa dikembangkan dengan integrasi Payment Gateway sungguhan seperti Midtrans."

---

## SLIDE 10: Penutup & Q&A
**Teks di Slide:**
- **Terima Kasih!**
- *Ada pertanyaan?*

**🗣️ Speaker Notes (Yang Diucapkan):**
> "Sekian presentasi dari Kelompok A-10 mengenai proyek SEWAIN. Terima kasih atas perhatiannya. Jika ada pertanyaan, masukan, atau saran, dengan senang hati akan kami persilakan."
