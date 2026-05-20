(function () {
  const navLinks = [
    { key: 'home',    label: 'Home',       href: 'index.html' },
    { key: 'rentals', label: 'Rentals',    href: 'rentals.html' },
    { key: 'katalog', label: 'My Katalog', href: 'katalog.html' },
  ];

  function renderNavbar(active) {
    const links = navLinks.map(l => `
      <a href="${l.href}" class="${l.key === active ? 'active' : ''}">${l.label}</a>
    `).join('');

    return `
      <nav class="navbar">
        <div class="container nav-inner">
          <a href="index.html" class="nav-logo">SEWA<span>IN</span></a>
          <div class="nav-links">${links}</div>
          <div class="nav-actions">
            <a href="cart.html" class="icon-btn" aria-label="Keranjang">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
              <span class="badge">2</span>
            </a>
            <a href="profile.html" class="icon-btn" aria-label="Profil">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <a href="signin.html" class="btn btn-primary btn-sm" style="border-radius:999px">Sign In</a>
          </div>
        </div>
      </nav>
    `;
  }

  function renderFooter() {
    return `
      <footer class="footer">
        <div class="container">
          <div class="footer-grid">
            <div class="footer-brand">
              <h3>SEWA<span style="font-weight:400">IN</span></h3>
              <p>Kami bantu kamu menemukan barang sewa berkualitas dengan harga ramah di kantong.</p>
              <div class="footer-socials" aria-label="Sosial media">
                <a href="#" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.4a4 4 0 1 1-7.9 1.2 4 4 0 0 1 7.9-1.2z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                <a href="#" aria-label="Twitter"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                <a href="#" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
              </div>
            </div>
            <div class="footer-col">
              <h4>Information</h4>
              <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Product</a></li>
                <li><a href="#">Blog</a></li>
              </ul>
            </div>
            <div class="footer-col">
              <h4>Company</h4>
              <ul>
                <li><a href="#">Community</a></li>
                <li><a href="#">Career</a></li>
                <li><a href="#">Our Story</a></li>
              </ul>
            </div>
            <div class="footer-col">
              <h4>Contact</h4>
              <ul>
                <li><a href="#">Getting Started</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Resources</a></li>
              </ul>
            </div>
          </div>
          <div class="footer-bottom">
            © 2026 SEWAIN. All Rights Reserved. Term of Use &amp; DMCA.
          </div>
        </div>
      </footer>
    `;
  }

  function mount() {
    const active = document.body.dataset.page || '';
    document.querySelectorAll('[data-component="navbar"]').forEach(el => {
      el.outerHTML = renderNavbar(active);
    });
    document.querySelectorAll('[data-component="footer"]').forEach(el => {
      el.outerHTML = renderFooter();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mount);
  } else {
    mount();
  }
})();
