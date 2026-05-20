<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SEWAIN — Sewa Barang Mudah & Terpercaya</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;1,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="resources/css/style.css" />
</head>
<body data-page="home">

  <div data-component="navbar"></div>

  <section class="hero">
    <div class="container hero-grid">
      <div class="hero-text">
        <span class="hero-eyebrow">Platform Sewa Terpercaya</span>
        <h1>Sewa barang <em>berkualitas</em> tanpa repot.</h1>
        <p>Mulai dari peralatan kamping, alat fotografi, hingga elektronik — semua bisa kamu sewa dengan mudah, aman, dan harga bersahabat.</p>
        <div class="hero-cta">
          <a href="rentals.html" class="btn btn-primary btn-lg">Mulai Sewa Sekarang</a>
          <a href="#kategori" class="btn btn-outline btn-lg">Lihat Kategori</a>
        </div>
      </div>
      <div class="hero-visual" aria-hidden="true">
        <span style="position:relative;z-index:1;">Gambar / Banner</span>
      </div>
    </div>
  </section>

  <section class="brand-strip">
    <div class="container brand-strip-inner">
      <span class="brand-logo">FUJIFILM</span>
      <span class="brand-logo">JEEP</span>
      <span class="brand-logo">Nationwide</span>
      <span class="brand-logo">Honda</span>
      <span class="brand-logo">Apple</span>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <h2 class="section-title">Tentang Kami</h2>
      <p class="section-subtitle">SEWAIN hadir untuk menyederhanakan cara kamu menyewa barang. Aman, cepat, dan transparan dari awal sampai akhir.</p>
      <div class="features">
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7l-9 9-5-5"/></svg>
          </div>
          <h4>Penyewaan Praktis</h4>
          <p>Proses booking ringkas tanpa berkas berlembar — cukup beberapa klik selesai.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h4>Aman &amp; Terpercaya</h4>
          <p>Setiap penyewa dan pemilik diverifikasi, transaksi terlindungi sistem escrow.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          </div>
          <h4>Harga Bersaing</h4>
          <p>Dapatkan barang yang kamu butuhkan dengan harga sewa yang fleksibel dan kompetitif.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" id="kategori" style="padding-top:0">
    <div class="container">
      <h2 class="section-title">Kategori</h2>
      <p class="section-subtitle">Jelajahi kategori populer pilihan komunitas SEWAIN.</p>
      <div class="categories-grid">
        <a href="rentals.html?cat=photography" class="category-card" style="background-color:#3a3a3a">
          <h3>Photography</h3>
          <p>Kamera, lensa, tripod &amp; lighting</p>
        </a>
        <a href="rentals.html?cat=outdoor" class="category-card" style="background-color:#4a5d4f">
          <h3>Outdoor</h3>
          <p>Tenda, sleeping bag, alat panjat</p>
        </a>
        <a href="rentals.html?cat=elektronik" class="category-card" style="background-color:#4b4b6b">
          <h3>Elektronik</h3>
          <p>Sound system, proyektor, laptop</p>
        </a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <h2 class="section-title">Rent Items</h2>
      <p class="section-subtitle">Pilihan barang yang sedang banyak disewa minggu ini.</p>
      <div class="products-grid" id="rent-items-grid"></div>
    </div>
  </section>

  <section class="testimonials">
    <div class="container">
      <h2 class="section-title">This Is What Our Customers Say</h2>
      <p class="section-subtitle">Cerita dari komunitas SEWAIN yang sudah merasakan manfaatnya.</p>
      <div class="testimonial-track">
        <article class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <blockquote>"Proses sewanya simpel banget, barang datang tepat waktu dan kondisinya bagus. Bakal sewa lagi pasti!"</blockquote>
          <div class="testimonial-author">
            <div class="testimonial-avatar"></div>
            <div><strong>Salwa C.</strong><span>Bandung</span></div>
          </div>
        </article>
        <article class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <blockquote>"Saya pakai untuk acara kantor, semua peralatan tersedia. Sangat membantu untuk yang butuh dadakan."</blockquote>
          <div class="testimonial-author">
            <div class="testimonial-avatar"></div>
            <div><strong>Dimas R.</strong><span>Jakarta</span></div>
          </div>
        </article>
        <article class="testimonial-card">
          <div class="testimonial-stars">★★★★☆</div>
          <blockquote>"Pertama kali nyobain, ternyata sangat user-friendly. Pemilik barangnya juga responsif lewat WhatsApp."</blockquote>
          <div class="testimonial-author">
            <div class="testimonial-avatar"></div>
            <div><strong>Aulia P.</strong><span>Yogyakarta</span></div>
          </div>
        </article>
        <article class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <blockquote>"Penyewaan tenda untuk camping akhir pekan kemarin lancar jaya. Harga juga lebih bersahabat dari toko sebelah."</blockquote>
          <div class="testimonial-author">
            <div class="testimonial-avatar"></div>
            <div><strong>Reza M.</strong><span>Surabaya</span></div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <div data-component="footer"></div>

  <script src="assets/js/components.js"></script>
  <script>
    const items = [
      { title: 'ALLTREK Tenda Camping Tentastic Outdoor 1 Bedroom + 1 Guest Room', price: 145000, rating: 4.8, badge: 'Outdoor', loc: 'Bandung' },
      { title: 'Yamaha Pro Audio Paket EJP Sound System',                          price: 320000, rating: 4.9, badge: 'Elektronik', loc: 'Bandung' },
      { title: 'Canon EOS R6 Mark II + Lensa Kit RF 24-105mm',                     price: 275000, rating: 5.0, badge: 'Photography', loc: 'Jakarta' },
      { title: 'Sleeping Bag Eiger Extreme Cold -10°C Series',                     price: 35000,  rating: 4.6, badge: 'Outdoor', loc: 'Bandung' },
      { title: 'DJI Mavic 3 Pro Drone Cinematic Combo',                            price: 410000, rating: 4.9, badge: 'Photography', loc: 'Jakarta' },
      { title: 'Proyektor BenQ Full HD 3500 Lumens Portable',                      price: 180000, rating: 4.7, badge: 'Elektronik', loc: 'Surabaya' },
    ];

    document.getElementById('rent-items-grid').innerHTML = items.map(it => `
      <article class="product-card" onclick="location.href='product.html'">
        <div class="product-image">
          <span class="product-badge">${it.badge}</span>
        </div>
        <div class="product-body">
          <h4 class="product-title">${it.title}</h4>
          <div class="product-meta">
            <span class="product-rating">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              ${it.rating}
            </span>
            <span>${it.loc}</span>
          </div>
          <div class="product-price">Rp ${it.price.toLocaleString('id-ID')}<span> / hari</span></div>
        </div>
      </article>
    `).join('');
  </script>
</body>
</html>
