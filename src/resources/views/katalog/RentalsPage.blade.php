<x-layout>
    <x-slot:styles>
        <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Pacifico&family=Poppins:wght@300;400;500;600;700&family=Vidaloka&family=Volkhov:wght@400;500;550;600;700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Lato:wght@400;700&family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/rentals.css') }}" />
    </x-slot:styles>

    <section class="hero">
        <div class="container">
            <div class="search-bar">
                <div class="search-field">
                    <label>Location</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <select class="search-select" id="searchLocation">
                            <option value="">Choose Location</option>
                        </select>
                    </div>
                </div>
                <div class="search-field">
                    <label>Find</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="search-input" id="searchFind" placeholder="Kamera" />
                    </div>
                </div>
                <div class="search-field">
                    <label>Sewa Up</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <circle cx="8" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="8" cy="18" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="12" cy="18" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none" />
                        </svg>
                        <span class="date-display" id="displayDateStart">Pilih tanggal</span>
                        <input type="date" class="date-hidden" id="searchDateStart" />
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
                <div class="search-field">
                    <label>Return</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <circle cx="8" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="8" cy="18" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="12" cy="18" r="0.8" fill="#55959E" stroke="none" />
                            <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none" />
                        </svg>
                        <span class="date-display" id="displayDateEnd">Pilih tanggal</span>
                        <input type="date" class="date-hidden" id="searchDateEnd" />
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
                <button class="btn-search" type="button">Search</button>
            </div>
        </div>
    </section>

    <section class="rentals-page">
        <div class="container">
            <h1 class="rentals-title">Rentals</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">›</span>
                <span class="current">Rentals</span>
            </nav>

            <div class="filters-section">
                <h2 class="filters-title">Filters</h2>
                <div class="filters-row">
                    <div class="filter-col">
                        <h3>Prices</h3>
                        <ul class="prices-list">
                            <li>Rp 0 - Rp 100.000</li>
                            <li>Rp 100.000 - Rp 250.000</li>
                            <li>Rp 250.000 - Rp 500.000</li>
                            <li>Rp 500.000 - Rp 750.000</li>
                            <li>Rp 750.000 - Rp 1000.000</li>
                        </ul>
                    </div>
                    <div class="filter-col">
                        <h3>Categories</h3>
                        <div class="categories-box">
                            <div class="cat-grid" id="categoryGrid"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="view-toggle">
                <button class="view-btn active" aria-label="List view">
                    <svg viewBox="0 0 24 14" fill="currentColor"><rect y="0" width="24" height="2"/><rect y="6" width="24" height="2"/><rect y="12" width="24" height="2"/></svg>
                </button>
                <button class="view-btn" aria-label="2 columns">
                    <svg viewBox="0 0 24 14" fill="currentColor"><rect x="9" y="0" width="2" height="14"/><rect x="13" y="0" width="2" height="14"/></svg>
                </button>
                <button class="view-btn" aria-label="3 columns">
                    <svg viewBox="0 0 24 14" fill="currentColor"><rect x="6" width="2" height="14"/><rect x="11" width="2" height="14"/><rect x="16" width="2" height="14"/></svg>
                </button>
                <button class="view-btn" aria-label="4 columns">
                    <svg viewBox="0 0 24 14" fill="currentColor"><rect x="3" width="2" height="14"/><rect x="9" width="2" height="14"/><rect x="15" width="2" height="14"/><rect x="21" width="2" height="14"/></svg>
                </button>
                <button class="view-btn" aria-label="5 columns">
                    <svg viewBox="0 0 24 14" fill="currentColor"><rect x="1" width="2" height="14"/><rect x="6" width="2" height="14"/><rect x="11" width="2" height="14"/><rect x="16" width="2" height="14"/><rect x="21" width="2" height="14"/></svg>
                </button>
            </div>

            <div class="rentals-grid" id="rentalsGrid"></div>
            <nav class="pagination" aria-label="Pagination"></nav>
        </div>
    </section>

    <script>
        const rentals = {!! json_encode($barangs->map(function($b) {
            return [
                'id' => $b->id,
                'title' => $b->nama_barang,
                'category' => strtolower($b->kategori->nama_kategori ?? 'others'),
                'loc' => $b->lokasi,
                'reviews' => 0,
                'rating' => 5,
                'price' => $b->harga_sewa,
                'img' => $b->foto_barang ? asset('storage/' . $b->foto_barang) : 'https://placehold.co/400x300?text=No+Image'
            ];
        })) !!};

        const ITEMS_PER_PAGE = 6;
        let currentPage = 1;
        let activeCategory = null;
        let activePriceMin = null;
        let activePriceMax = null;
        let activeSearchLoc = '';
        let activeSearchFind = '';

        const priceRanges = [
            { min: 0, max: 100000 },
            { min: 100000, max: 250000 },
            { min: 250000, max: 500000 },
            { min: 500000, max: 750000 },
            { min: 750000, max: 1000000 },
        ];

        const stars = n => '★★★★★☆☆☆☆☆'.slice(5 - n, 10 - n);
        const locSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`;

        const categoryGrid = document.getElementById('categoryGrid');
        const categories = [...new Set(rentals.map(it => it.category).filter(Boolean))];
        categoryGrid.innerHTML = categories.length
            ? categories.map(category => `<span>${category}</span>`).join('')
            : '<span class="category-empty">Belum ada kategori</span>';

        function getFiltered() {
            return rentals.filter(it => {
                const catOk = !activeCategory || it.category === activeCategory;
                const priceOk = activePriceMin === null || (it.price >= activePriceMin && it.price <= activePriceMax);
                const locOk = !activeSearchLoc || it.loc.toLowerCase().includes(activeSearchLoc);
                const findOk = !activeSearchFind || it.title.toLowerCase().includes(activeSearchFind);
                return catOk && priceOk && locOk && findOk;
            });
        }

        function renderPage(page) {
            const filtered = getFiltered();
            const total = Math.ceil(filtered.length / ITEMS_PER_PAGE);
            const start = (page - 1) * ITEMS_PER_PAGE;
            const pageItems = filtered.slice(start, start + ITEMS_PER_PAGE);
            const grid = document.getElementById('rentalsGrid');

            if (pageItems.length === 0) {
                grid.innerHTML = `<div class="rentals-empty" style="grid-column:1/-1; text-align:center; padding:48px 24px;">
                    <h3 style="margin:0 0 8px; font-family:'Poppins',sans-serif; font-size:20px; color:#1f2937;">Belum ada barang tersedia</h3>
                    <p style="margin:0; font-family:'Poppins',sans-serif; font-size:14px; color:#8A8A8A;">Rental akan otomatis mengikuti katalog yang diunggah penyedia.</p>
                </div>`;
            } else {
                grid.innerHTML = pageItems.map(it => `
                    <article class="rental-card" style="cursor: pointer;" onclick="location.href='/product/${it.id}'">
                        <div class="rental-img"><img src="${it.img}" alt="${it.title}" onerror="this.style.display='none'"/></div>
                        <div class="head-row">
                            <h4>${it.title}</h4>
                            <span class="rating">${stars(it.rating)}</span>
                        </div>
                        <div class="loc">${locSvg} ${it.loc}</div>
                        <div class="reviews">(${it.reviews}) Customer Reviews</div>
                        <div class="price">Rp ${it.price.toLocaleString('id-ID')}/hari</div>
                    </article>`).join('');
            }

            updatePagination(total);
        }

        function updatePagination(total) {
            const pag = document.querySelector('.pagination');
            if (!pag) {
                return;
            }
            if (total <= 1) {
                pag.innerHTML = '';
                return;
            }

            let html = '';
            for (let i = 1; i <= total; i++) {
                html += `<button class="${i === currentPage ? 'active' : ''}">${i}</button>`;
            }
            html += `<button class="nav" aria-label="Next">»</button>`;
            pag.innerHTML = html;

            pag.querySelectorAll('button:not(.nav)').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPage = parseInt(btn.textContent);
                    renderPage(currentPage);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            pag.querySelector('.nav').addEventListener('click', () => {
                if (currentPage < total) {
                    currentPage++;
                    renderPage(currentPage);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        }

        document.querySelectorAll('.view-btn').forEach((btn, idx) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cols = [1, 2, 3, 4, 5][idx];
                document.getElementById('rentalsGrid').style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
            });
        });

        document.querySelectorAll('.cat-grid span').forEach(s => {
            s.addEventListener('click', () => {
                const val = s.textContent.trim().toLowerCase();
                if (activeCategory === val) {
                    activeCategory = null;
                    document.querySelectorAll('.cat-grid span').forEach(x => x.classList.remove('active'));
                } else {
                    activeCategory = val;
                    document.querySelectorAll('.cat-grid span').forEach(x => x.classList.remove('active'));
                    s.classList.add('active');
                }
                currentPage = 1;
                renderPage(1);
            });
        });

        document.querySelectorAll('.prices-list li').forEach((li, idx) => {
            li.addEventListener('click', () => {
                if (activePriceMin === priceRanges[idx].min && activePriceMax === priceRanges[idx].max) {
                    activePriceMin = null;
                    activePriceMax = null;
                    document.querySelectorAll('.prices-list li').forEach(x => x.classList.remove('active'));
                } else {
                    activePriceMin = priceRanges[idx].min;
                    activePriceMax = priceRanges[idx].max;
                    document.querySelectorAll('.prices-list li').forEach(x => x.classList.remove('active'));
                    li.classList.add('active');
                }
                currentPage = 1;
                renderPage(1);
            });
        });

        document.querySelector('.btn-search').addEventListener('click', () => {
            const loc = document.getElementById('searchLocation').value.toLowerCase();
            const find = document.getElementById('searchFind').value.toLowerCase();
            activeSearchLoc = loc;
            activeSearchFind = find;
            currentPage = 1;
            renderPage(1);
        });

        const locations = [...new Set(rentals.map(it => it.loc))];
        const selectEl = document.getElementById('searchLocation');
        locations.forEach(loc => {
            const opt = document.createElement('option');
            opt.value = loc.toLowerCase();
            opt.textContent = loc;
            selectEl.appendChild(opt);
        });

        document.getElementById('searchDateStart').addEventListener('change', function() {
            const d = new Date(this.value);
            document.getElementById('displayDateStart').textContent =
                d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        });

        document.getElementById('searchDateEnd').addEventListener('change', function() {
            const d = new Date(this.value);
            document.getElementById('displayDateEnd').textContent =
                d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        });

        document.querySelector('.katalog-search input')?.addEventListener('input', function() {
            activeSearchFind = this.value.toLowerCase();
            currentPage = 1;
            renderPage(1);
        });

        // Terima kata kunci pencarian dari halaman Home (mis. /rentals?find=kamera&loc=bandung)
        const urlParams = new URLSearchParams(window.location.search);
        const qFind = (urlParams.get('find') || '').trim();
        const qLoc = (urlParams.get('loc') || '').trim();
        if (qFind) {
            activeSearchFind = qFind.toLowerCase();
            const findInput = document.getElementById('searchFind');
            if (findInput) findInput.value = qFind;
        }
        if (qLoc) {
            activeSearchLoc = qLoc.toLowerCase();
            selectEl.value = qLoc.toLowerCase();
        }

        renderPage(1);
    </script>
</x-layout>
