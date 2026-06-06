<x-layout title="My Katalogs — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/katalog.css') }}" />
    </x-slot:styles>

    <section class="katalog-page">
        <div class="container" style="max-width:1280px;">

            <h1 class="katalog-title">My Katalogs</h1>
            <nav class="katalog-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">›</span>
                <span class="current">My Katalogs</span>
            </nav>

            {{-- ============ PROFILE CARD ============ --}}
            <div class="profile-card">
                <div class="profile-photo">
                    @php
                        $authUser = auth()->user();
                        $fotoProfil = ($authUser && $authUser->foto_profil)
                            ? asset('storage/' . $authUser->foto_profil)
                            : asset('assets/img/katalog/profile-placeholder.jpg');
                    @endphp
                    <img src="{{ $fotoProfil }}" alt="{{ $authUser->name ?? 'User' }}"
                        onerror="this.style.display='none'" />
                </div>
                <div class="profile-info">
                    <h2 class="profile-name">{{ $authUser->name ?? 'Pengguna' }}</h2>
                    <div class="profile-detail-grid">
                        <div class="label lokasi-label">
                            <svg width="12" height="15" viewBox="0 0 12 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.66667 7.08333C6.05625 7.08333 6.38976 6.94462 6.66719 6.66719C6.94462 6.38976 7.08333 6.05625 7.08333 5.66667C7.08333 5.27708 6.94462 4.94358 6.66719 4.66615C6.38976 4.38872 6.05625 4.25 5.66667 4.25C5.27708 4.25 4.94358 4.38872 4.66615 4.66615C4.38872 4.94358 4.25 5.27708 4.25 5.66667C4.25 6.05625 4.38872 6.38976 4.66615 6.66719C4.94358 6.94462 5.27708 7.08333 5.66667 7.08333ZM5.66667 14.1667C3.76597 12.5493 2.34635 11.047 1.40781 9.6599C0.469271 8.27274 0 6.98889 0 5.80833C0 4.0375 0.569618 2.62674 1.70885 1.57604C2.84809 0.525347 4.16736 0 5.66667 0C7.16597 0 8.48524 0.525347 9.62448 1.57604C10.7637 2.62674 11.3333 4.0375 11.3333 5.80833C11.3333 6.98889 10.8641 8.27274 9.92552 9.6599C8.98698 11.047 7.56736 12.5493 5.66667 14.1667Z"
                                    fill="#727272" />
                            </svg>
                            Lokasi
                        </div>
                        <div class="value">{{ $authUser->alamat ?? 'Belum diatur' }}</div>

                        <div class="label">Rating</div>
                        <div class="value">
                            <span class="star" style="color: #f5b800;">★</span>
                            <span style="position: relative; top: 4px;"> 5,0 ({{ $barangs->count() }} Item)</span>
                        </div>

                        <div class="label">Jumlah Katalog</div>
                        <div class="value" id="jumlahKatalog">{{ $barangs->count() }} Barang</div>

                        <div class="label wa-label">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.2019 13.2332V15.7332C18.2029 15.9653 18.153 16.195 18.0554 16.4077C17.9577 16.6203 17.8145 16.8112 17.635 16.9681C17.4554 17.125 17.2434 17.2445 17.0126 17.3188C16.7817 17.3932 16.5371 17.4208 16.2944 17.3999C13.6019 17.1213 11.0155 16.245 8.74316 14.8416C6.62901 13.5621 4.83658 11.855 3.49316 9.84155C2.01439 7.66756 1.09412 5.19238 0.806907 2.61655C0.785041 2.38611 0.813797 2.15385 0.891345 1.93457C0.968892 1.71529 1.09353 1.51379 1.25733 1.3429C1.42112 1.17201 1.62049 1.03548 1.84272 0.941987C2.06496 0.848498 2.3052 0.800103 2.54816 0.799885H5.17316C5.5978 0.795905 6.00947 0.939118 6.33145 1.20283C6.65342 1.46654 6.86372 1.83276 6.92316 2.23322C7.03395 3.03327 7.23943 3.81882 7.53566 4.57489C7.65338 4.87316 7.67886 5.19731 7.60907 5.50895C7.53929 5.82059 7.37716 6.10664 7.14191 6.33322L6.03066 7.39155C7.27627 9.47784 9.09005 11.2053 11.2807 12.3916L12.3919 11.3332C12.6298 11.1092 12.9302 10.9548 13.2574 10.8883C13.5846 10.8218 13.925 10.8461 14.2382 10.9582C15.032 11.2403 15.8568 11.436 16.6969 11.5416C17.122 11.5987 17.5101 11.8026 17.7876 12.1145C18.0651 12.4264 18.2126 12.8245 18.2019 13.2332Z"
                                    stroke="#1E1E1E" stroke-width="1.6" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            WhatsApp
                        </div>
                        <div class="value">{{ $authUser->phone_number ?? 'Belum diatur' }}</div>
                    </div>
                </div>
            </div>

            {{-- ============ SEARCH ============ --}}
            <div class="katalog-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="search" id="katalogSearch" placeholder="Search something here" aria-label="Search" />
            </div>

            {{-- ============ VIEW TOGGLE ============ --}}
            <div class="katalog-toolbar">
                <div class="view-toggle">
                    <button class="view-btn active" aria-label="List view">
                        <svg viewBox="0 0 24 14" fill="currentColor">
                            <rect y="0" width="24" height="2" />
                            <rect y="6" width="24" height="2" />
                            <rect y="12" width="24" height="2" />
                        </svg>
                    </button>
                    <button class="view-btn" aria-label="2 columns">
                        <svg viewBox="0 0 24 14" fill="currentColor">
                            <rect x="9" width="2" height="14" />
                            <rect x="13" width="2" height="14" />
                        </svg>
                    </button>
                    <button class="view-btn" aria-label="3 columns">
                        <svg viewBox="0 0 24 14" fill="currentColor">
                            <rect x="6" width="2" height="14" />
                            <rect x="11" width="2" height="14" />
                            <rect x="16" width="2" height="14" />
                        </svg>
                    </button>
                    <button class="view-btn" aria-label="4 columns">
                        <svg viewBox="0 0 24 14" fill="currentColor">
                            <rect x="3" width="2" height="14" />
                            <rect x="9" width="2" height="14" />
                            <rect x="15" width="2" height="14" />
                            <rect x="21" width="2" height="14" />
                        </svg>
                    </button>
                    <button class="view-btn" aria-label="5 columns">
                        <svg viewBox="0 0 24 14" fill="currentColor">
                            <rect x="1" width="2" height="14" />
                            <rect x="6" width="2" height="14" />
                            <rect x="11" width="2" height="14" />
                            <rect x="16" width="2" height="14" />
                            <rect x="21" width="2" height="14" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ============ GRID PRODUK (dirender Blade, bukan JS) ============ --}}
            <div class="katalog-grid" id="katalogGrid">
                @forelse($barangs as $barang)
                    <x-katalog-card :barang="$barang" />
                @empty
                    <x-product-empty message="Belum ada katalog yang diunggah." />
                @endforelse

                {{-- Tombol Add New Item selalu muncul di akhir grid --}}
                <a class="add-item-card" href="{{ route('katalog.add-item') }}">
                    <div class="plus-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    <div class="add-text">ADD NEW ITEM</div>
                </a>
            </div>

            <nav class="katalog-pagination" id="katalogPagination" aria-label="Pagination"></nav>

        </div>
    </section>

    <x-slot:scripts>
        <script>
            /**
             * Data produk diambil dari data-attributes HTML yang sudah dirender Blade.
             * JavaScript HANYA mengurus: search, view-toggle, pagination, prepareEdit().
             * Tidak ada lagi innerHTML template string di sini.
             */

            const ITEMS_PER_PAGE = 6;
            let currentPage = 1;
            let activeSearch = '';

            // Ambil semua kartu dari DOM (dirender Blade)
            const allCards = Array.from(document.querySelectorAll('#katalogGrid .katalog-card'));
            const addCard  = document.querySelector('#katalogGrid .add-item-card');
            const grid     = document.getElementById('katalogGrid');
            const pagNav   = document.getElementById('katalogPagination');

            function getFiltered() {
                return allCards.filter(card => {
                    if (!activeSearch) return true;
                    const title = card.dataset.title?.toLowerCase() ?? '';
                    const loc   = card.dataset.loc?.toLowerCase() ?? '';
                    return title.includes(activeSearch) || loc.includes(activeSearch);
                });
            }

            function renderPage(page) {
                const filtered = getFiltered();
                const total    = Math.ceil(filtered.length / ITEMS_PER_PAGE);
                const start    = (page - 1) * ITEMS_PER_PAGE;
                const visible  = filtered.slice(start, start + ITEMS_PER_PAGE);

                // Sembunyikan semua kartu dahulu
                allCards.forEach(c => c.style.display = 'none');
                // Tampilkan kartu halaman aktif
                visible.forEach(c => c.style.display = '');

                updatePagination(total);
                equalizeCardHeight();
            }

            function updatePagination(total) {
                if (total <= 1) { pagNav.innerHTML = ''; return; }
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

            // View toggle
            document.querySelectorAll('.view-btn').forEach((btn, idx) => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const cols = [1, 2, 3, 4, 5][idx];
                    grid.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
                });
            });

            // Search live
            document.getElementById('katalogSearch').addEventListener('input', function () {
                activeSearch = this.value.toLowerCase();
                currentPage = 1;
                renderPage(1);
            });

            /**
             * prepareEdit – Membaca data dari data-attributes kartu Blade,
             * simpan ke localStorage, lalu redirect ke halaman edit.
             */
            function prepareEdit(itemId) {
                const card = document.querySelector(`.katalog-card[data-id="${itemId}"]`);
                if (!card) return;

                const d = card.dataset;
                const productData = {
                    tglMulai   : d.tglMulai,
                    tglSelesai : d.tglSelesai,
                    nama       : d.title,
                    kategori   : d.kategori,
                    harga      : parseInt(d.price),
                    deskripsi  : d.deskripsi,
                    addInfo    : d.addInfo,
                    stok       : parseInt(d.stock),
                    img        : d.img,
                    pemilik    : {
                        wa     : d.wa,
                        jaminan: d.jaminan,
                        denda  : isNaN(d.denda) ? d.denda : 'Rp ' + parseInt(d.denda).toLocaleString('id-ID') + '/jam',
                        lokasi : d.loc
                    }
                };

                localStorage.setItem('publishedItem', JSON.stringify(productData));
                window.location.href = '/katalog/edit-item/' + itemId;
            }

            function equalizeCardHeight() {
                setTimeout(() => {
                    const productCard = document.querySelector('.katalog-card');
                    const addItemCard = document.querySelector('.add-item-card');
                    if (productCard && addItemCard) {
                        addItemCard.style.minHeight = productCard.offsetHeight + 'px';
                    }
                }, 50);
            }

            // Render awal
            renderPage(1);
        </script>
    </x-slot:scripts>
</x-layout>
