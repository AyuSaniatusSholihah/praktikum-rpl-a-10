# Isi Lengkap Presentasi Proyek RPL (Versi Ultimate - 45 Slide)

Berikut adalah *master document* presentasi paling komprehensif yang dirancang untuk membedah sistem **SEWAIN** secara menyeluruh (dari latar belakang, analisis, UML, Database, hingga perjalanan fitur satu per satu). Silakan *copy-paste* poin-poin ini ke dalam aplikasi presentasi Anda (PowerPoint / Canva).

---

## 📌 BAGIAN 1: PENDAHULUAN & LATAR BELAKANG

**SLIDE 1: Cover / Judul**
- **Judul:** SEWAIN - Platform Sistem Informasi Penyewaan Barang Terintegrasi
- **Konteks:** Proyek Akhir Mata Kuliah Rekayasa Perangkat Lunak
- **Tim Pengembang (Kelompok A-10):**
  - APRILIA ALFA GUSASTI CIPTANINGTYAS (L0124003)
  - AYU SANIATUS SHOLIHAH (L0124005)
  - GHAZI FAHMI RAMADHAN (L0124130)
- 🗣️ *Speaker Notes:* "Selamat pagi/siang. Kami dari Kelompok A-10 akan mempresentasikan proyek akhir kami: SEWAIN, sebuah platform penyewaan barang terpadu."

**SLIDE 2: Latar Belakang Masalah**
- **Kondisi Konvensional:** Penyewaan barang di masyarakat masih bergantung pada interaksi tatap muka atau chat pribadi.
- **Keterbatasan Media:** WhatsApp atau media sosial tidak dirancang khusus untuk manajemen reservasi barang.
- 🗣️ *Speaker Notes:* "Proyek ini berangkat dari kenyataan bahwa proses sewa-menyewa barang harian, seperti kamera atau alat camping, masih sangat manual dan tidak terkelola dengan baik karena hanya mengandalkan chat."

**SLIDE 3: Problem Statement (Titik Nyeri)**
- ❌ **Jadwal Bentrok:** Informasi ketersediaan barang sering tidak *up-to-date*.
- ❌ **Miskomunikasi Harga & Denda:** Tidak ada *invoice* resmi, denda sering diperdebatkan.
- ❌ **Kurangnya Rasa Percaya:** Pemilik waswas barangnya dicuri/rusak, penyewa waswas barang tidak sesuai.
- 🗣️ *Speaker Notes:* "Dari proses manual tersebut timbul banyak masalah: jadwal sering bentrok, kesepakatan harga dan denda sering kabur, dan yang terpenting: tidak adanya jaminan keamanan (trust issue) antar pihak."

**SLIDE 4: Potensi & Peluang Ekonomi**
- 📦 **Aset Menganggur (Idle Assets):** Banyak individu memiliki barang mahal (gaun, kamera, tenda) yang hanya disimpan di lemari.
- 💰 **Passive Income:** Barang tersebut bisa diberdayakan menjadi sumber pendapatan.
- 🗣️ *Speaker Notes:* "Di balik masalah itu, ada peluang besar. Banyak orang punya barang mahal yang nganggur. Mereka ingin menyewakannya sebagai tambahan penghasilan, tapi takut karena belum ada platform penengah yang aman."

**SLIDE 5: Solusi: SEWAIN**
- **Platform Marketplace Sewa:** Menjembatani Pemilik Barang (Owner) dan Penyewa dalam satu sistem terpusat.
- **Fokus Sistem:** Sentralisasi katalog, manajemen pemesanan, dan transparansi aturan sewa.
- 🗣️ *Speaker Notes:* "SEWAIN hadir sebagai solusi. Sebuah platform yang bertindak layaknya e-commerce, tapi khusus untuk memfasilitasi transaksi sewa-menyewa secara aman, terstruktur, dan transparan."

**SLIDE 6: Ruang Lingkup Proyek**
- Membangun aplikasi berbasis *Web* (Responsive).
- Menargetkan 3 entitas: Penyewa, Owner, dan Admin.
- Cakupan fitur: Autentikasi, Katalog, Keranjang, Transaksi, dan Rekam Jejak (Review & Log).
- 🗣️ *Speaker Notes:* "Ruang lingkup proyek kami adalah membangun web responsif yang melayani 3 aktor utama dengan fitur lengkap dari awal hingga akhir siklus penyewaan."

---

## 📌 BAGIAN 2: ANALISIS KEBUTUHAN PENGGUNA

**SLIDE 7: User Personas (Target Pengguna)**
- 🧑 **Penyewa:** Mahasiswa atau masyarakat umum yang butuh barang sementara tanpa harus membeli.
- 💼 **Owner:** Individu/rental kecil yang ingin memonetisasi aset mereka.
- 🛡️ **Admin:** Moderator sistem yang menjaga ekosistem agar bersih dari penipu.
- 🗣️ *Speaker Notes:* "Kami memulai analisis dengan menetapkan Persona Pengguna. Kami merancang fitur aplikasi secara spesifik untuk memuaskan kebutuhan 3 kelompok ini."

**SLIDE 8: User Stories (Penyewa)**
- Sebagai Penyewa, saya ingin *mem-filter barang berdasarkan kategori*, agar saya cepat menemukan barang.
- Sebagai Penyewa, saya ingin *menyewa banyak barang sekaligus (Cart)*, agar menghemat waktu checkout.
- 🗣️ *Speaker Notes:* "Melalui metode User Stories, kami menangkap kebutuhan Penyewa. Misalnya, mereka butuh fitur keranjang untuk mem-booking barang dari beberapa owner sekaligus."

**SLIDE 9: User Stories (Owner)**
- Sebagai Owner, saya ingin *bisa menerima/menolak pesanan*, agar saya bisa memastikan kesiapan barang saya.
- Sebagai Owner, saya ingin *menambahkan denda otomatis*, agar penyewa disiplin mengembalikan barang.
- 🗣️ *Speaker Notes:* "Untuk Owner, kebutuhan terbesarnya adalah kendali. Mereka butuh wewenang untuk menolak pesanan jika barang sedang bermasalah, serta jaminan denda keterlambatan yang adil."

**SLIDE 10: User Stories (Admin)**
- Sebagai Admin, saya ingin *melihat seluruh riwayat aktivitas (log)*, agar mudah melacak insiden.
- Sebagai Admin, saya ingin *bisa membekukan akun (freeze)*, agar pelaku kecurangan tidak bisa menggunakan platform lagi.
- 🗣️ *Speaker Notes:* "Bagi Admin, kebutuhannya adalah monitoring dan wewenang eksekusi. Mereka harus bisa melihat log aktivitas dan mem-banned akun yang melanggar aturan SEWAIN."

**SLIDE 11: Use Case Diagram**
- *(Visual: Sisipkan gambar Use Case Diagram keseluruhan)*
- **Fokus:** Menunjukkan relasi spesifik antar Aktor dan Sistem.
- 🗣️ *Speaker Notes:* "Ini adalah Use Case Diagram kami yang merangkum seluruh User Stories tadi ke dalam peta interaksi yang jelas antara Penyewa, Owner, Admin, dan Sistem."

**SLIDE 12: Activity Diagram - Autentikasi**
- *(Visual: Sisipkan gambar Activity Diagram pendaftaran/login)*
- **Alur:** Register $\rightarrow$ Input Email $\rightarrow$ Kirim OTP $\rightarrow$ Verifikasi OTP $\rightarrow$ Akun Aktif.
- 🗣️ *Speaker Notes:* "Kami merancang Activity Diagram untuk login/register. Keamanannya sangat ketat karena mewajibkan verifikasi OTP untuk mencegah bot dan akun bodong."

**SLIDE 13: Activity Diagram - Alur Sewa Utama**
- *(Visual: Sisipkan gambar Activity Diagram transaksi penyewaan)*
- **Flow:** Pilih Barang $\rightarrow$ Checkout $\rightarrow$ **Verifikasi Owner** $\rightarrow$ Bayar $\rightarrow$ Penggunaan $\rightarrow$ Upload Bukti Kembali $\rightarrow$ Verifikasi Pengembalian $\rightarrow$ Selesai.
- 🗣️ *Speaker Notes:* "Ini adalah jantung dari SEWAIN. Proses sewa memiliki gerbang ganda: Persetujuan Owner sebelum pembayaran, dan Verifikasi Owner setelah barang dikembalikan."

---

## 📌 BAGIAN 3: PERANCANGAN SISTEM & BASIS DATA

**SLIDE 14: Arsitektur Sistem**
- **Metode Pendekatan:** Model-View-Controller (MVC).
- **Alur Kerja:** Pemisahan *logic* database (Model), tampilan layar (View), dan pemroses alur bisnis (Controller).
- 🗣️ *Speaker Notes:* "Dalam implementasi, kami memakai pola desain arsitektur MVC yang disediakan oleh framework Laravel. Ini membuat kode proyek kami sangat rapi dan mudah di-maintain."

**SLIDE 15: Teknologi & Stack Pilihan**
- **Backend:** PHP 8 & Laravel Framework.
- **Frontend:** Laravel Blade, HTML5, Vanilla CSS (Custom Design), JavaScript.
- **Database:** MySQL / MariaDB.
- 🗣️ *Speaker Notes:* "Stack teknologi yang kami gunakan berfokus pada performa dan stabilitas. Backend kokoh menggunakan Laravel, dan frontend dibangun dengan Vanilla CSS agar tampilannya unik dan bebas dari keterbatasan template bawaan."

**SLIDE 16: Entity Relationship Diagram (ERD) - Master Data**
- *(Visual: Sisipkan potongan ERD tabel Users, Kategoris, Barangs)*
- **Relasi Kompleks 1-to-Many:** Satu User bisa punya banyak Barang, Satu Kategori menaungi banyak Barang.
- 🗣️ *Speaker Notes:* "Beralih ke ERD, ini adalah desain basis data kami untuk Master Data. Rancangan tabel barang dibuat mendetail agar bisa menyimpan hingga 5 sisi foto produk dan info teknis lainnya."

**SLIDE 17: Entity Relationship Diagram (ERD) - Transaksional**
- *(Visual: Sisipkan potongan ERD tabel Orders, Transaksi, Keranjangs)*
- **Pemisahan Entitas:** Tabel `orders` (untuk 1 invoice global) dipisah dari `transaksi_penyewaans` (detail per barang).
- 🗣️ *Speaker Notes:* "Untuk mencatat transaksi, kami memisahkan tabel Order dan Transaksi. Kenapa? Karena saat checkout, penyewa bisa meminjam 3 barang dari owner yang berbeda. Semuanya dibayar 1 kali di Order, tapi dipecah menjadi 3 baris Transaksi untuk masing-masing Owner."

**SLIDE 18: Class Diagram**
- *(Visual: Sisipkan gambar Class Diagram)*
- Pemodelan hubungan *HasMany*, *BelongsTo*, dan interaksi antara *Controllers* dengan *Models*.
- 🗣️ *Speaker Notes:* "Ini adalah representasi Class Diagram dari kode kami. Menunjukkan dengan persis struktur class di dalam Laravel, method apa saja yang ada, dan bagaimana controller saling berinteraksi dengan model."

**SLIDE 19: Proteksi & Keamanan Sistem**
- **Authentication:** Password Hash (Bcrypt), verifikasi token OTP.
- **Role-Based Access Control (RBAC):** Middleware khusus untuk mencegah *Penyewa* masuk ke *Dashboard Admin* via URL.
- 🗣️ *Speaker Notes:* "Keamanan adalah prioritas. Kami melindungi aplikasi dengan hashing yang kuat, serta RBAC atau pembedaan *role*. Jika Anda penyewa, Anda akan diblokir oleh Middleware bila mencoba mengakses URL admin."

**SLIDE 20: Desain UI/UX (Wireframe vs Implementasi)**
- *(Visual: Sandingkan gambar desain dasar/wireframe dengan hasil web asli)*
- Konsistensi antara rancangan awal dan produk perangkat lunak akhir.
- 🗣️ *Speaker Notes:* "Rekayasa perangkat lunak yang baik selalu melalui tahap desain UI/UX. Gambar ini membuktikan bahwa kami konsisten menerjemahkan Wireframe menjadi tampilan web responsif yang elegan."

---

## 📌 BAGIAN 4: BEDAH FITUR - PERJALANAN PENYEWA (USER JOURNEY)

**SLIDE 21: Fitur 1 - Landing Page & Pintu Utama**
- *(Visual: Screenshot Landing Page SEWAIN)*
- Sambutan yang *user-friendly*, navigasi instan, dan penayangan *Web Reviews* (Testimoni).
- 🗣️ *Speaker Notes:* "Sekarang mari kita bedah fiturnya satu per satu berdasarkan User Journey. Semua berawal dari Landing Page yang didesain estetik untuk memikat pengguna dan menumbuhkan rasa percaya melalui testimoni."

**SLIDE 22: Fitur 2 - Registrasi Cerdas (Anti-Spam)**
- *(Visual: Screenshot Form Register & Halaman Verifikasi OTP Email)*
- Pendaftaran menuntut aktivasi via kode 6-digit OTP yang dikirim ke email asli pengguna.
- 🗣️ *Speaker Notes:* "Untuk mendaftar, kami tidak sembarangan menerima akun. Pengguna wajib memasukkan OTP yang dikirim langsung ke email mereka. Ini adalah benteng pertama kami dari spammer."

**SLIDE 23: Fitur 3 - Autentikasi Google OAuth**
- *(Visual: Screenshot opsi "Login with Google")*
- Integrasi *API Google Sign-in* menggunakan Laravel Socialite.
- 🗣️ *Speaker Notes:* "Untuk mempercepat proses on-boarding, kami menyuntikkan teknologi OAuth. Pengguna bisa masuk hanya dengan 1 kali klik menggunakan akun Google mereka, jauh lebih efisien tanpa harus menghafal password."

**SLIDE 24: Fitur 4 - Manajemen Profil Komprehensif**
- *(Visual: Screenshot Halaman Edit Profil)*
- Pengguna wajib melengkapi profil (No. HP, Alamat lengkap, Foto) sebelum bisa bertransaksi.
- 🗣️ *Speaker Notes:* "Demi keamanan, pengguna didorong untuk melengkapi biodata dan mengunggah foto profil asli. Data diri yang transparan akan meningkatkan probabilitas persetujuan dari Owner."

**SLIDE 25: Fitur 5 - My Wallet (Saldo Virtual)**
- *(Visual: Screenshot Halaman Wallet / Saldo)*
- Dompet digital internal untuk mensimulasikan sistem pembayaran dan pengembalian dana (*refund*).
- 🗣️ *Speaker Notes:* "Kami juga mengimplementasikan sistem *My Wallet*. Saldo virtual ini dirancang untuk mempermudah simulasi transaksi pembayaran serta pengembalian dana denda jika diperlukan."

**SLIDE 26: Fitur 6 - Eksplorasi Katalog Barang**
- *(Visual: Screenshot Product Grid / List Barang)*
- Menampilkan gambar barang, harga sewa/hari, rating, dan label ketersediaan stok.
- 🗣️ *Speaker Notes:* "Saat masuk sebagai penyewa, mereka akan dihidangkan halaman katalog. Kami menampilkannya dalam format grid yang rapi, lengkap dengan label ketersediaan, agar penyewa tahu mana barang yang bisa disewa hari ini."

**SLIDE 27: Fitur 7 - Fitur Pencarian & Filter Spesifik**
- *(Visual: Screenshot Search Bar & Kategori)*
- *Live Search* dan filter berbasis kategori (Elektronik, Alat Gunung, dsb).
- 🗣️ *Speaker Notes:* "Pencarian tidak perlu memakan waktu lama. Fitur Search dan Filter Kategori kami optimalkan agar query ke database berjalan cepat dan akurat menampilkan barang yang dituju."

**SLIDE 28: Fitur 8 - Halaman Detail Barang (Multiple Images)**
- *(Visual: Screenshot Detail Barang dengan Slider Foto)*
- Memuat informasi mendalam: Deskripsi panjang, uang jaminan, denda/jam, syarat tambahan, dan galeri foto.
- 🗣️ *Speaker Notes:* "Di halaman detail, penyewa dapat melihat syarat sewa, besaran denda jika telat, dan fitur *image gallery*. Fitur ini mendukung owner untuk menampilkan hingga 5 foto berbeda untuk satu barang."

**SLIDE 29: Fitur 9 - Keranjang (Cart) Multi-Item**
- *(Visual: Screenshot Keranjang Belanja)*
- Bisa menampung banyak barang. Pengguna wajib mendefinisikan *Tanggal Sewa* dan *Rencana Kembali* untuk setiap item.
- 🗣️ *Speaker Notes:* "Kami membangun fitur keranjang layaknya marketplace pada umumnya. Namun karena ini adalah penyewaan, saat menekan *Add to Cart*, pengguna wajib menentukan rentang waktu sewanya."

**SLIDE 30: Fitur 10 - Checkout Terpadu & Detail Alamat**
- *(Visual: Screenshot Halaman Checkout/Form Alamat)*
- Pengguna melengkapi form pengiriman (First/Last name, Alamat, Kota, Kode Pos, Metode Ekspedisi).
- 🗣️ *Speaker Notes:* "Saat checkout, sistem kami akan menyimpan detail alamat dan data penerima ke dalam tabel *Orders*. Data inilah yang akan dipakai Owner untuk mengirimkan atau menyerahkan barang."

---

## 📌 BAGIAN 5: FITUR OWNER & MANAJEMEN PENYEWAAN

**SLIDE 31: Fitur 11 - Dashboard Owner (Manajemen Item)**
- *(Visual: Screenshot Data Barang Milik Owner)*
- Interface khusus (CRUD) bagi pengguna yang berstatus pemilik barang untuk menambah katalog dan foto.
- 🗣️ *Speaker Notes:* "Berpindah peran menjadi Owner. Aplikasi ini memfasilitasi user biasa untuk menjadi Owner. Mereka diberi dashboard khusus untuk membuat etalase barang mereka sendiri."

**SLIDE 32: Fitur 12 - Sistem Verifikasi Owner (Gatekeeper)**
- *(Visual: Screenshot List Pesanan Masuk & Tombol Approve/Reject)*
- State: **"Menunggu Persetujuan"**. Owner meninjau durasi sewa & profil penyewa.
- 🗣️ *Speaker Notes:* "Ini adalah fitur proteksi andalan SEWAIN. Pesanan yang masuk *tidak* langsung potong saldo. Owner berhak mengkaji dulu. Jika jadwal bentrok atau barang mendadak rusak, Owner bisa menekan tombol Tolak."

**SLIDE 33: Fitur 13 - State Machine Transaksi (Status Barang)**
- Status bergulir secara dinamis: *Upcoming* $\rightarrow$ *Aktif* $\rightarrow$ *Tunggu Verifikasi* $\rightarrow$ *Selesai*.
- 🗣️ *Speaker Notes:* "Sistem kami dibangun di atas logika *State Machine*. Status barang berubah-ubah secara otomatis seiring dengan tahap transaksi, sehingga pelacakan barang sangat akurat."

---

## 📌 BAGIAN 6: PEMBAYARAN, PENGEMBALIAN & ULASAN

**SLIDE 34: Fitur 14 - Pembayaran via Saldo Sistem**
- *(Visual: Screenshot Notifikasi Berhasil Bayar & Saldo Terpotong)*
- Jika pesanan di-*Approve*, Penyewa melunasi pembayaran yang memotong *My Wallet*.
- 🗣️ *Speaker Notes:* "Setelah pesanan disetujui, penyewa harus membayar. Sistem secara matematis memotong saldo dompet pengguna dan memindahkan status barang menjadi aktif disewa."

**SLIDE 35: Fitur 15 - Protokol Pengembalian (Upload Bukti)**
- *(Visual: Screenshot Halaman Upload Bukti Foto)*
- Kewajiban penyewa: Menekan "Kembalikan Barang" dan mengunggah foto paket resi / kondisi barang terbaru.
- 🗣️ *Speaker Notes:* "Sewa sudah selesai? Belum tentu. Saat mengembalikan, penyewa *diwajibkan* mengunggah foto bukti barang yang dikembalikan untuk mencegah perselisihan kondisi barang."

**SLIDE 36: Fitur 16 - Konfirmasi Owner (Penutupan Siklus)**
- *(Visual: Screenshot Owner Menerima & Menutup Transaksi)*
- Owner memeriksa bukti foto dan menekan "Verifikasi Pengembalian". Transaksi barulah berstatus *Selesai*.
- 🗣️ *Speaker Notes:* "Owner kemudian melihat bukti foto tersebut. Jika semuanya aman, Owner menekan konfirmasi, dan siklus transaksi secara resmi dinyatakan *Selesai* oleh sistem."

**SLIDE 37: Fitur 17 - Algoritma Denda Keterlambatan**
- Perhitungan kalkulasi otomatis *(Tanggal Kembali Aktual - Rencana Kembali) x Harga Denda/Jam*.
- 🗣️ *Speaker Notes:* "Bagaimana jika penyewa telat mengembalikan? Backend kami memiliki algoritma penghitung jam otomatis. Jika telat 3 jam, sistem akan mengalikan jumlah keterlambatan dengan tarif denda yang disetel Owner sejak awal."

**SLIDE 38: Fitur 18 - Sistem Ulasan & Reputasi**
- *(Visual: Screenshot Form Penilaian 1-5 Bintang)*
- Transaksi selesai mewajibkan penyewa memberikan penilaian bintang dan ulasan tertulis.
- 🗣️ *Speaker Notes:* "Transaksi sukses berujung pada pemberian rating dan review. Rating ini diakumulasi ke dalam profil barang, membangun reputasi Owner secara organik di dalam platform."

---

## 📌 BAGIAN 7: MODERASI ADMIN

**SLIDE 39: Fitur 19 - Dashboard Monitoring Admin**
- *(Visual: Screenshot Halaman Utama Admin)*
- *Helicopter view*: Memantau total *Users*, jumlah barang terdaftar, dan *cashflow* transaksi.
- 🗣️ *Speaker Notes:* "Beralih ke peran tertinggi: Admin. Admin memiliki dashboard statistik untuk memonitor kesehatan dan perputaran transaksi yang terjadi di seluruh platform SEWAIN."

**SLIDE 40: Fitur 20 - Keamanan Komunitas (Freeze / Ban Account)**
- *(Visual: Screenshot Daftar User & Tombol BAN)*
- Kewenangan absolut untuk membekukan akun yang melakukan pelanggaran (misal: penipuan sewa/barang rusak).
- 🗣️ *Speaker Notes:* "Demi keamanan komunitas, Admin memegang palu hukum. Jika ada laporan penipuan, Admin dapat segera menekan tombol *Ban* (Blokir). Akun tersebut secara instan akan kehilangan hak akses login."

**SLIDE 41: Fitur 21 - Activity Logging (Jejak Digital Sistem)**
- Sistem senantiasa merekam segala aktivitas krusial pengguna (*Create, Update, Delete*) ke dalam tabel `activity_logs`.
- 🗣️ *Speaker Notes:* "Kami juga menerapkan fitur Audit Trail. Segala aksi yang dilakukan pengguna dicatat di dalam Log Sistem secara rahasia, memastikan setiap *error* atau perselisihan bisa diselidiki jejak digitalnya."

---

## 📌 BAGIAN 8: KESIMPULAN & PENUTUP

**SLIDE 42: Kendala & Tantangan Teknis**
- **Sistem Keranjang Sewa:** Merupakan *logic* yang sulit karena barang *rental* punya konsep waktu (tidak seperti beli putus).
- **Relasi Database Kompleks:** Menggabungkan tabel pesanan, transaksi, dan histori waktu.
- 🗣️ *Speaker Notes:* "Pengembangan proyek ini cukup menantang. Secara teknis, membuat keranjang sewa jauh lebih kompleks daripada keranjang toko biasa, karena ada parameter 'waktu pinjam dan kembali' yang harus ditangani hati-hati."

**SLIDE 43: Pencapaian & Kesimpulan**
- **Sukses Membangun Ekosistem:** Berhasil mewujudkan sebuah aplikasi web berskala penuh (*Full-stack*).
- **Proses Rekayasa Valid:** Terbukti mendesain solusi berbasis masalah (RPL).
- 🗣️ *Speaker Notes:* "Namun, kerja keras kelompok A-10 terbayar lunas. Kami sukses merancang sistem SEWAIN dari sebuah analisis masalah kosong, hingga menjadi perangkat lunak nyata dengan puluhan fitur fungsional."

**SLIDE 44: Future Development (Rencana Masa Depan)**
- Implementasi *Payment Gateway* resmi (Midtrans / Xendit).
- Fitur *Chat* In-App secara real-time.
- Notifikasi WhatsApp / Email *Reminder* jadwal pengembalian.
- 🗣️ *Speaker Notes:* "Aplikasi ini punya pondasi kuat. Ke depannya, kami dapat dengan mudah memasangkan Payment Gateway asli, fitur Chat langsung di dalam aplikasi, hingga notifikasi pengingat via WhatsApp."

**SLIDE 45: Q&A dan Penutup**
- **Terima Kasih atas Perhatian Anda!**
- Repositori Proyek: *[Link Github Proyek]*
- *Sesi Tanya Jawab (Q&A)*
- 🗣️ *Speaker Notes:* "Sekian presentasi bedah sistem SEWAIN dari Kelompok A-10. Terima kasih atas apresiasi dan perhatian bapak/ibu serta teman-teman. Kami membuka sesi tanya jawab untuk hal yang kurang jelas."
