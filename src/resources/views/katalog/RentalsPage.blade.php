<x-layout title="Rentals — SEWAIN">
    <x-slot:styles>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/rentals.css') }}" />
    </x-slot:styles>

    {{-- ============ HERO / SEARCH BAR ============ --}}
    <section class="hero">
        <div class="container">
            <div class="search-bar">
                <div class="search-field">
                    <label>Location</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <select class="search-select" id="searchLocation">
                            <option value="">Choose Location</option>
                            @foreach($locations as $loc)
                                <option value="{{ strtolower($loc) }}">{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="search-field">
                    <label>Find</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" class="search-input" id="searchFind" placeholder="Kamera" />
                    </div>
                </div>

                <div class="search-field">
                    <label>Sewa Up</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <circle cx="8"  cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="8"  cy="18" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="12" cy="18" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none"/>
                        </svg>
                        <span class="date-display" id="displayDateStart">Pilih tanggal</span>
                        <input type="date" class="date-hidden" id="searchDateStart" />
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                </div>

                <div class="search-field">
                    <label>Return</label>
                    <div class="value">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <circle cx="8"  cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="12" cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="16" cy="14" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="8"  cy="18" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="12" cy="18" r="0.8" fill="#55959E" stroke="none"/>
                            <circle cx="16" cy="18" r="0.8" fill="#55959E" stroke="none"/>
                        </svg>
                        <span class="date-display" id="displayDateEnd">Pilih tanggal</span>
                        <input type="date" class="date-hidden" id="searchDateEnd" />
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                </div>

                <button class="btn-search" type="button" id="btnSearch">Search</button>
            </div>
        </div>
    </section>

    {{-- ============ RENTALS SECTION ============ --}}
    <section class="rentals-page">
        <div class="container">
            <h1 class="rentals-title">Rentals</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">›</span>
                <span class="current">Rentals</span>
            </nav>

            {{-- ============ FILTER ============ --}}
            <div class="filters-section">
                <h2 class="filters-title">Filters</h2>
                <div class="filters-row">
                    <div class="filter-col">
                        <h3>Prices</h3>
                        <ul class="prices-list">
                            <li data-min="0"       data-max="100000">Rp 0 - Rp 100.000</li>
                            <li data-min="100000"  data-max="250000">Rp 100.000 - Rp 250.000</li>
                            <li data-min="250000"  data-max="500000">Rp 250.000 - Rp 500.000</li>
                            <li data-min="500000"  data-max="750000">Rp 500.000 - Rp 750.000</li>
                            <li data-min="750000"  data-max="1000000">Rp 750.000 - Rp 1.000.000</li>
                        </ul>
                    </div>
                    <div class="filter-col">
                        <h3>Categories</h3>
                        <div class="categories-box">
                            <div class="cat-grid" id="categoryGrid">
                                @foreach($categories as $cat)
                                    <span data-category="{{ strtolower($cat) }}">{{ ucfirst($cat) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ VIEW TOGGLE ============ --}}
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

            {{-- ============ GRID PRODUK (dirender Blade) ============ --}}
            <div class="rentals-grid" id="rentalsGrid">
                @forelse($barangs as $barang)
                    <x-rental-card :barang="$barang" />
                @empty
                    <x-product-empty />
                @endforelse
            </div>

            <nav class="pagination" id="rentalsPagination" aria-label="Pagination"></nav>
        </div>
    </section>

    <script>
        /**
         * JavaScript hanya mengurus filter + pagination.
         * HTML card sudah dirender Blade (server-side).
         * Filter bekerja dengan show/hide DOM, bukan innerHTML.
         */

        const ITEMS_PER_PAGE = 6;
        let currentPage      = 1;
        let activeCategory   = null;
        let activePriceMin   = null;
        let activePriceMax   = null;
        let activeSearchLoc  = '';
        let activeSearchFind = '';

        const allCards = Array.from(document.querySelectorAll('#rentalsGrid .rental-card'));
        const grid     = document.getElementById('rentalsGrid');
        const pagNav   = document.getElementById('rentalsPagination');

        // Baca URL params dari halaman home (?find=...&loc=...)
        const urlParams = new URLSearchParams(window.location.search);
        const qFind = (urlParams.get('find') || '').trim().toLowerCase();
        const qLoc  = (urlParams.get('loc')  || '').trim().toLowerCase();
        if (qFind) { activeSearchFind = qFind; document.getElementById('searchFind').value = urlParams.get('find'); }
        if (qLoc)  { activeSearchLoc  = qLoc;  document.getElementById('searchLocation').value = qLoc; }

        function getFiltered() {
            return allCards.filter(card => {
                const catOk   = !activeCategory  || card.dataset.category === activeCategory;
                const priceOk = activePriceMin === null ||
                                (parseInt(card.dataset.price) >= activePriceMin &&
                                 parseInt(card.dataset.price) <= activePriceMax);
                const locOk   = !activeSearchLoc  || card.dataset.loc.includes(activeSearchLoc);
                const findOk  = !activeSearchFind || card.dataset.title.includes(activeSearchFind);
                return catOk && priceOk && locOk && findOk;
            });
        }

        // Tampilan "belum ada" menggunakan komponen product-empty yang sudah ada di DOM
        const emptyEl = document.querySelector('#rentalsGrid .rentals-empty');

        function renderPage(page) {
            const filtered = getFiltered();
            const total    = Math.ceil(filtered.length / ITEMS_PER_PAGE);
            const start    = (page - 1) * ITEMS_PER_PAGE;
            const visible  = filtered.slice(start, start + ITEMS_PER_PAGE);

            allCards.forEach(c => c.style.display = 'none');
            visible.forEach(c => c.style.display = '');

            // Tampilkan/sembunyikan pesan kosong
            if (emptyEl) emptyEl.style.display = visible.length === 0 ? '' : 'none';

            updatePagination(total);
        }

        function updatePagination(total) {
            if (total < 1) { pagNav.innerHTML = ''; return; }
            let html = '';
            for (let i = 1; i <= total; i++) {
                html += `<button class="${i === currentPage ? 'active' : ''}">${i}</button>`;
            }
            html += `<button class="nav" aria-label="Next">»</button>`;
            pagNav.innerHTML = html;

            pagNav.querySelectorAll('button:not(.nav)').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPage = parseInt(btn.textContent);
                    renderPage(currentPage);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
            pagNav.querySelector('.nav').addEventListener('click', () => {
                if (currentPage < total) { currentPage++; renderPage(currentPage); window.scrollTo({ top: 0, behavior: 'smooth' }); }
            });
        }

        // Filter Kategori
        document.querySelectorAll('.cat-grid span').forEach(s => {
            s.addEventListener('click', () => {
                const val = s.dataset.category;
                if (activeCategory === val) {
                    activeCategory = null;
                    document.querySelectorAll('.cat-grid span').forEach(x => x.classList.remove('active'));
                } else {
                    activeCategory = val;
                    document.querySelectorAll('.cat-grid span').forEach(x => x.classList.remove('active'));
                    s.classList.add('active');
                }
                currentPage = 1; renderPage(1);
            });
        });

        // Filter Harga
        document.querySelectorAll('.prices-list li').forEach(li => {
            li.addEventListener('click', () => {
                const min = parseInt(li.dataset.min);
                const max = parseInt(li.dataset.max);
                if (activePriceMin === min && activePriceMax === max) {
                    activePriceMin = activePriceMax = null;
                    document.querySelectorAll('.prices-list li').forEach(x => x.classList.remove('active'));
                } else {
                    activePriceMin = min; activePriceMax = max;
                    document.querySelectorAll('.prices-list li').forEach(x => x.classList.remove('active'));
                    li.classList.add('active');
                }
                currentPage = 1; renderPage(1);
            });
        });

        // Search Button
        document.getElementById('btnSearch').addEventListener('click', () => {
            activeSearchLoc  = document.getElementById('searchLocation').value.toLowerCase();
            activeSearchFind = document.getElementById('searchFind').value.toLowerCase();
            currentPage = 1; renderPage(1);
        });

        // Date Display
        document.getElementById('searchDateStart').addEventListener('change', function () {
            document.getElementById('displayDateStart').textContent =
                new Date(this.value).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        });
        document.getElementById('searchDateEnd').addEventListener('change', function () {
            document.getElementById('displayDateEnd').textContent =
                new Date(this.value).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        });

        // View Toggle
        document.querySelectorAll('.view-btn').forEach((btn, idx) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                grid.style.gridTemplateColumns = `repeat(${[1,2,3,4,5][idx]}, 1fr)`;
            });
        });

        // Render awal
        renderPage(1);
    </script>
</x-layout>