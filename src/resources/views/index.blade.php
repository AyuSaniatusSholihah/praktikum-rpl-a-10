<x-layout>
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    </x-slot:styles>

<section class="hero">
 <div class="container">
<div class="hero-grid">

  <!-- KIRI -->
  <div class="hero-col">
    <div class="hero-img-wrap hero-left-wrap">
      <div class="hero-img hero-left">
        <img src="{{ asset('assets/img/Kamera.jpg') }}" alt="Camera" />
      </div>
    </div>
  </div>

  <!-- TENGAH -->
  <div class="hero-col">
    <div class="hero-img-wrap hero-top-wrap">
      <div class="hero-img hero-mid-top">
        <img src="{{ asset('assets/img/Kamera.jpg') }}" alt="Tent" />
      </div>
    </div>
    <div class="hero-center-text">
      <div class="all">ALL YOU</div>
      <div class="can">can</div>
      <div class="rent">RENT</div>
      <button class="btn-rent" onclick="location.href='{{ route('rentals') ?? '#' }}'">RENT NOW</button>
    </div>
    <div class="hero-img hero-mid-bottom">
      <img src="{{ asset('assets/img/Motor & Mobil.jpg') }}" alt="Car" />
    </div>
  </div>

  <!-- KANAN -->
  <div class="hero-col">
    <div class="hero-img-wrap hero-right-wrap">
      <div class="hero-img hero-right">
        <img src="{{ asset('assets/img/Produk Apple.jpg') }}" alt="Electronics" />
      </div>
    </div>
  </div>

</div>

   <form class="search-bar" action="{{ route('rentals') }}" method="GET">
     <div class="search-field">
       <label>Location</label>
       <div class="value">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
         <input type="text" name="loc" value="{{ request('loc') }}" placeholder="Lokasi" autocomplete="off" style="border:none;background:transparent;outline:none;font:inherit;color:inherit;width:100%;padding:0;" />
       </div>
     </div>
     <div class="search-field">
       <label>Find</label>
       <div class="value">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
         <input type="text" name="find" value="{{ request('find') }}" placeholder="Cari barang..." autocomplete="off" style="border:none;background:transparent;outline:none;font:inherit;color:inherit;width:100%;padding:0;" />
       </div>
     </div>
     <div class="search-field">
       <label>Sewa Up</label>
       <div class="value">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
          <!-- titik-titik tanggal -->
          <circle cx="8"  cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="8"  cy="18" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="12" cy="18" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none"/>
        </svg>
         17 July 2024
         <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
       </div>
     </div>
     <div class="search-field">
       <label>Return</label>
       <div class="value">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
          <!-- titik-titik tanggal -->
          <circle cx="8"  cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="8"  cy="18" r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="12" cy="18" , r="0.8" fill="#55959E" stroke="none"/>
          <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none"/>
        </svg>
         20 July 2024
         <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
       </div>
     </div>
     <button class="btn-search" type="submit">Search</button>
   </form>
 </div>
</section>

<section class="brand-strip">
 <div class="container brand-strip-inner">
  <img src="{{ asset('assets/img/Merk 1.png') }}" alt="Brand 1" class="brand-logo" />
    <img src="{{ asset('assets/img/Merk 2.png') }}" alt="Brand 2" class="brand-logo" />
    <img src="{{ asset('assets/img/Merk 3.png') }}" alt="Brand 3" class="brand-logo" />
    <img src="{{ asset('assets/img/Merk 4.png') }}" alt="Brand 4" class="brand-logo" />
    <img src="{{ asset('assets/img/Merk 5.png') }}" alt="Brand 5" class="brand-logo" />
 </div>
</section>

<section class="about-section">
 <div class="container">
   <h2>About us</h2>
   <p class="about-text">
     SEWAIN adalah Platform digital yang menyediakan layanan penyewaan berbagai kebutuhan sehari-hari dengan mudah, cepat, dan terpercaya. Kami hadir untuk membantu pengguna menemukan dan menyewa barang tanpa harus membeli, sehingga lebih praktis dan hemat.
   </p>
   <p class="about-text">
     Dengan berbagai pilihan kategori seperti elektronik, kamera, perlengkapan outdoor, hingga kebutuhan event, SEWAIN menjadi solusi bagi siapa saja yang membutuhkan barang untuk penggunaan sementara.
   </p>
   <p class="about-text">SEWAIN — Sewa Mudah, Hidup Lebih Praktis.</p>

   <div class="feature-grid">
     <div class="feature-item">
       <div class="feature-icon">
        <!-- Wide Range of Rentals: ikon box/package -->
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
          <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
          <line x1="12" y1="22.08" x2="12" y2="12"/>
        </svg>
       </div>
       <h4>Wide Range of Rentals</h4>
       <p>Various items available across multiple categories</p>
     </div>
     <div class="feature-item">
       <div class="feature-icon">
        <!-- Easy & Fast Booking: ikon kalender/grid -->
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
          <line x1="8" y1="14" x2="8" y2="14"/>
          <line x1="12" y1="14" x2="12" y2="14"/>
          <line x1="16" y1="14" x2="16" y2="14"/>
        </svg>
       </div>
       <h4>Easy &amp; Fast Booking</h4>
       <p>Rent items in just a few simple steps</p>
     </div>
     <div class="feature-item">
       <div class="feature-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 12 19.79 19.79 0 0 1 1.08 3.38 2 2 0 0 1 3.05 1h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91A16 16 0 0 0 13 14.91l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
       </div>
       <h4>24/7 Support</h4>
       <p>We're here to help anytime you need</p>
     </div>
   </div>
 </div>
</section>

<section class="categories-section">
 <div class="container">
   <h2 class="section-title">Categories</h2>
   <p class="section-subtitle">Find what you are looking for</p>
    <div class="categories-slider-wrapper">
      <button class="cat-arrow cat-arrow-left" id="catPrev">‹</button>
      <div class="categories-wrap" id="categoriesTrack">
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Photography.webp') }}?w=400&q=80" alt="Photography" onerror="this.style.display='none'"/>
          </div>
          <h4>Photography</h4>
          <p>Abadikan setiap momen indahmu dengan kamera berkualitas</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=photography'">Explore →</button>
        </div>
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Vehicles.avif') }}?w=400&q=80" alt="Vehicles" onerror="this.style.display='none'"/>
          </div>
          <h4>Vehicles</h4>
          <p>Sewa kendaraan impian untuk perjalanan tak terlupakan</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=vehicles'">Explore →</button>
        </div>
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Camping.png') }}?w=400&q=80" alt="Camping" onerror="this.style.display='none'"/>
          </div>
          <h4>Camping</h4>
          <p>Petualangan outdoor jadi lebih mudah dengan perlengkapan camping</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=camping'">Explore →</button>
        </div>
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Fashion.jpg') }}?w=400&q=80" alt="Fashion" onerror="this.style.display='none'"/>
          </div>
          <h4>Fashion</h4>
          <p>Temukan gaya terbaru dengan menyewa pakaian impian</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=fashion'">Explore →</button>
        </div>
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Tools.jpg') }}?w=400&q=80" alt="Tools" onerror="this.style.display='none'"/>
          </div>
          <h4>Tools</h4>
          <p>Peralatan berkualitas untuk kebutuhan sehari-hari</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=tools'">Explore →</button>
        </div>
        <div class="category-card">
          <div class="cat-img">
            <img src="{{ asset('assets/img/Kategori Electronic.jpg') }}?w=400&q=80" alt="Electronics" onerror="this.style.display='none'"/>
          </div>
          <h4>Electronics</h4>
          <p>Alat elektronik berkualitas untuk kebutuhan sehari-hari</p>
          <button class="btn-explore" onclick="location.href='{{ route('rentals') ?? '#' }}?cat=electronics'">Explore →</button>
        </div>
      </div>
      <button class="cat-arrow cat-arrow-right" id="catNext">›</button>
    </div>
 </div>
</section>

<section class="rent-section">
 <div class="container">
   <h2 class="section-title">Rent Items</h2>
   <p class="section-subtitle">Temukan berbagai barang pilihan yang siap mendukung aktivitasmu.<br/>Proses sewa mudah, barang berkualitas, dan siap antar kapan saja.</p>
   <div class="products-grid" id="rent-items-grid">
     @foreach($barangs->take(6) as $barang)
     <article class="product-card" onclick="location.href='{{ route('product.show', $barang->id) }}'">
       <div class="product-img"><img src="{{ $barang->foto_barang ? asset('storage/' . $barang->foto_barang) : 'https://placehold.co/400x300?text=No+Image' }}" alt="{{ $barang->nama_barang }}" /></div>
       <div class="head-row">
         <h4>{{ $barang->nama_barang }}</h4>
         <span class="rating">★★★★★</span>
       </div>
       <div class="loc">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;margin-right:4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
         {{ $barang->lokasi }}
       </div>
       <div class="reviews">(0) Customer Reviews</div>
       <div class="price">Rp {{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</div>
     </article>
     @endforeach
   </div>
   <button class="btn-view-more" onclick="location.href='{{ route('rentals') ?? '#' }}'">View More</button>
 </div>
</section>

<section class="testi-section">
 <div class="container">
   <h2 class="section-title">This Is What Our Customers Say</h2>
   <p class="section-subtitle">Ratusan orang telah mempercayakan website SEWAIN sebagai tempat<br/>penyewaan terpercaya, praktis, &amp; aman.</p>
   <div class="testi-track" id="testiTrack"></div>
   <div class="testi-nav">
     <button id="testiPrev" aria-label="Previous">‹</button>
     <button id="testiNext" aria-label="Next">›</button>
   </div>
 </div>
</section>

<x-slot:scripts>
<script>
  const productUrl = "{{ Route::has('product') ? route('product') : '#' }}";
</script>
<script>
 /* ============ TESTIMONIALS CAROUSEL ============ */
const testimonials = [
  { name: 'Karen W.',  role: 'Fotografer',      stars: 5,
    img: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=160&h=160&fit=crop',
    text: 'Saya selalu kesini buat sewa kamera. Thanks ya for making it easier untuk dapat barang dengan kualitas top.' },

  { name: 'James C.',  role: 'Mahasiswa',        stars: 5,
    img: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&h=160&fit=crop',
    text: 'Penyewaan ini sangatlah terpercaya dan aman, mulai dari pembayaran hingga barang sewaannya.' },

  { name: 'Salwa C.',  role: 'Karyawan',         stars: 5,
    img: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=160&h=160&fit=crop',
    text: 'Prosesnya cepat dan barangnya sesuai foto. Akan sewa lagi pasti!' },

  { name: 'Dimas R.',  role: 'Event Organizer',  stars: 5,
    img: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&h=160&fit=crop',
    text: 'Saya pakai untuk acara kantor, semua peralatan tersedia. Sangat membantu untuk yang butuh dadakan.' },

  { name: 'Aulia P.',  role: 'Content Creator',  stars: 4,
    img: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&h=160&fit=crop',
    text: 'Pertama kali nyobain, ternyata sangat user-friendly. Pemilik barangnya juga responsif lewat WhatsApp.' },

  { name: 'Reza M.',   role: 'Pendaki',          stars: 5,
    img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=160&h=160&fit=crop',
    text: 'Penyewaan tenda untuk camping akhir pekan kemarin lancar jaya. Harga juga lebih bersahabat dari toko sebelah.' },
];

 let testiIndex = 0;
 const track = document.getElementById('testiTrack');

 function renderTesti() {
   const total = testimonials.length;
   const prev = (testiIndex - 1 + total) % total;
   const next = (testiIndex + 1) % total;
   const show = [
     { ...testimonials[prev], side: 'left' },
     { ...testimonials[testiIndex], side: '' },
     { ...testimonials[next], side: 'right' },
   ];
   track.innerHTML = show.map(t => `
     <article class="testi-card${t.side ? ' side ' + t.side : ''}">
       <div class="testi-photo-wrap">
        <div class="testi-photo">
        <img src="${t.img}" alt="${t.name}"/>
        </div>
        </div>
       <div class="testi-body">
         <p class="testi-text">"${t.text}"</p>
         <div class="testi-stars">${'★'.repeat(t.stars)}${'☆'.repeat(5 - t.stars)}</div>
         <hr/>
         <div class="testi-name">${t.name}</div>
         <div class="testi-role">${t.role}</div>
       </div>
     </article>
   `).join('');
 }

 document.getElementById('testiPrev').addEventListener('click', () => {
   testiIndex = (testiIndex - 1 + testimonials.length) % testimonials.length;
   renderTesti();
 });
 document.getElementById('testiNext').addEventListener('click', () => {
   testiIndex = (testiIndex + 1) % testimonials.length;
   renderTesti();
 });

 renderTesti();

const catCards = Array.from(document.querySelectorAll('.category-card'));
let catMiddle = 1;

function updateCatDisplay() {
  const total = catCards.length;
  const leftIdx  = (catMiddle - 1 + total) % total;
  const midIdx   = catMiddle;
  const rightIdx = (catMiddle + 1) % total;

  // sembunyikan semua
  catCards.forEach(card => {
    card.style.display = 'none';
    card.style.transform = '';
    card.style.order = '';
    card.style.animation = '';
    card.classList.remove('cat-active');
    const desc = card.querySelector('p');
    const btn  = card.querySelector('.btn-explore');
    if (desc) desc.style.display = 'none';
    if (btn)  btn.style.display  = 'none';
  });

  // kiri — order 1
  catCards[leftIdx].style.display = 'flex';
  catCards[leftIdx].style.order = '1';
  catCards[leftIdx].style.transform = 'translateY(-60px)';

  // tengah — order 2
  catCards[midIdx].style.display = 'flex';
  catCards[midIdx].style.order = '2';
  catCards[midIdx].style.transform = 'translateY(0px)';
  catCards[midIdx].classList.add('cat-active');
  const desc = catCards[midIdx].querySelector('p');
  const btn  = catCards[midIdx].querySelector('.btn-explore');
  if (desc) desc.style.display = 'block';
  if (btn)  btn.style.display  = 'inline-flex';

  // kanan — order 3
  catCards[rightIdx].style.display = 'flex';
  catCards[rightIdx].style.order = '3';
  catCards[rightIdx].style.transform = 'translateY(-60px)';
  
  // Berikan animasi fade in khusus untuk kartu yang baru muncul
  catCards[leftIdx].style.animation = 'none';
  catCards[rightIdx].style.animation = 'none';
  // Reflow
  void catCards[leftIdx].offsetWidth;
  void catCards[rightIdx].offsetWidth;
  
  if (window.catDir === 'next') {
     catCards[rightIdx].style.animation = 'catFadeInRight 0.3s ease forwards';
  } else if (window.catDir === 'prev') {
     catCards[leftIdx].style.animation = 'catFadeInLeft 0.3s ease forwards';
  }
}

document.getElementById('catPrev').addEventListener('click', () => {
  window.catDir = 'prev';
  catMiddle = (catMiddle - 1 + catCards.length) % catCards.length;
  updateCatDisplay();
});
document.getElementById('catNext').addEventListener('click', () => {
  window.catDir = 'next';
  catMiddle = (catMiddle + 1) % catCards.length;
  updateCatDisplay();
});

updateCatDisplay();
</script>

</x-slot:scripts>
</x-layout>


