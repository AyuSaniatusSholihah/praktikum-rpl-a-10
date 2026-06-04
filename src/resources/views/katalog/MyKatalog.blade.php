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

            <div class="profile-card">
                <div class="profile-photo">
                    <img src="{{ asset('assets/img/katalog/profile-placeholder.jpg') }}" alt="Camping Groups Bandung"
                        onerror="this.style.display='none'" />
                </div>
                <div class="profile-info">
                    <h2 class="profile-name">Camping Groups Bandung</h2>
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
                        <div class="value">Kota Bandung</div>

                        <div class="label">Rating</div>
                        <div class="value">
                            <span class="star">★</span>
                            <span style="position: relative; top: 4px;"> 4,3 (120 Reviews)</span>
                        </div>

                        <div class="label">Jumlah Katalog</div>
                        <div class="value" id="jumlahKatalog">0 Barang</div>

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
                        <div class="value">0821-5620-9034</div>
                    </div>
                </div>
            </div>

            <div class="katalog-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="search" placeholder="Search something here" aria-label="Search" />
            </div>

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

            <div class="katalog-grid" id="katalogGrid"></div>

            <nav class="katalog-pagination" aria-label="Pagination">
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button class="nav" aria-label="Next">»</button>
            </nav>

        </div>
    </section>

    <x-slot:scripts>
        <script>
            // Mengambil data murni dari database melalui Laravel Eloquent Map tanpa data dummy bawaan
            const katalogs = {!! json_encode(
                $barangs->map(function ($b) {
                    return [
                        'id' => $b->id,
                        'title' => $b->nama_barang,
                        'loc' => $b->lokasi,
                        'reviews' => 0,
                        'rating' => 5,
                        'price' => (int) $b->harga_sewa,
                        'stock' => (int) $b->stok,
                        'status' => 'AVAILABLE',
                        'img' => $b->foto_barang
                            ? asset('storage/' . $b->foto_barang)
                            : 'https://placehold.co/400x300?text=No+Image',
            
                        // Mengirimkan properti database tambahan untuk di-map ke object localstorage edit
                        'deskripsi' => $b->deskripsi,
                        'addInfo' => $b->additional_info ?? '',
                        'kategori' => $b->kategori->nama_kategori ?? 'Camping',
                        'tglMulai' => $b->tanggal_item_mulai,
                        'tglSelesai' => $b->tanggal_item_tidak_tersedia,
                        'wa' => $b->whatsapp ?? '0821-5620-9034',
                        'jaminan' => $b->harga_jaminan,
                        'denda' => $b->harga_denda_perjam,
                    ];
                }),
            ) !!};

            const stars = n => '★★★★★☆☆☆☆☆'.slice(5 - n, 10 - n);
            const locSvg =
                `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`;
            const stockSvg =
                `<svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.4997 5.16667V16H2.49967V5.16667M8.33301 8.5H11.6663M0.833008 1H19.1663V5.16667H0.833008V1Z" stroke="#484848" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

            const grid = document.getElementById('katalogGrid');

            // Mengubah trigger click card produk agar memanggil fungsi pengisian localStorage edititempage
            const itemHTML = it => `
    <article class="katalog-card" style="cursor: pointer;" onclick="prepareEdit(${it.id})">
      <span class="katalog-badge ${it.status === 'ACTIVE RENTAL' ? 'active' : ''}">${it.status}</span>
      <div class="product-img"><img src="${it.img}" alt="${it.title}" onerror="this.style.display='none'"/></div>
      <div class="head-row">
        <h4>${it.title}</h4>
        <span class="rating">${stars(it.rating)}</span>
      </div>
      <div class="loc">${locSvg} ${it.loc}</div>
      <div class="reviews">(${it.reviews}) Customer Reviews</div>
      <div class="price">Rp ${it.price.toLocaleString('id-ID')}/hari</div>
      <div class="stock-footer">
        ${stockSvg}
        <span class="stock-text-only" style="position: relative; top: 1px;">${it.stock} ${it.stock === 1 ? 'Unit' : 'Units'} in Stock</span>
      </div>
    </article>
  `;

            const addCardHTML = `
    <a class="add-item-card" href="{{ route('katalog.add-item') ?? '#' }}">
      <div class="plus-circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </div>
      <div class="add-text">ADD NEW ITEM</div>
    </a>
  `;

            const ITEMS_PER_PAGE = 6;
            let currentPage = 1;
            let activeSearch = '';

            function getFiltered() {
                return katalogs.filter(it =>
                    !activeSearch ||
                    it.title.toLowerCase().includes(activeSearch) ||
                    it.loc.toLowerCase().includes(activeSearch)
                );
            }

            function renderPage(page) {
                const filtered = getFiltered();
                const total = Math.ceil(filtered.length / ITEMS_PER_PAGE);
                const start = (page - 1) * ITEMS_PER_PAGE;
                const pageItems = filtered.slice(start, start + ITEMS_PER_PAGE);

                if (pageItems.length === 0) {
                    grid.innerHTML =
                        `<p style="color:#8A8A8A; font-family:'Poppins',sans-serif; font-size:14px; grid-column:1/-1; text-align:center; padding:40px 0;">Belum ada katalog yang diunggah.</p>${addCardHTML}`;
                } else {
                    grid.innerHTML = pageItems.map(itemHTML).join('') + addCardHTML;
                }
                updatePagination(total);
                equalizeCardHeight();
            }

            /**
             * FUNGSI SINKRONISASI EDIT BARANG:
             * Mengemas data murni dari database array ke dalam manifest variabel 'saved' 
             * yang SAMA PERSIS dengan apa yang dicari di dalam script edititempage Anda.
             */
            function prepareEdit(itemId) {
                const selectedItem = katalogs.find(it => it.id === itemId);
                if (!selectedItem) return;

                // Memetakan struktur data murni agar 100% kompatibel dengan key di edititempage
                const productData = {
                    tglMulai: selectedItem.tglMulai,
                    tglSelesai: selectedItem.tglSelesai,
                    nama: selectedItem.title,
                    kategori: selectedItem.kategori,
                    harga: selectedItem.price,
                    deskripsi: selectedItem.deskripsi,
                    addInfo: selectedItem.addInfo,
                    stok: selectedItem.stock,
                    img: selectedItem.img,
                    pemilik: {
                        wa: selectedItem.wa,
                        jaminan: selectedItem.jaminan,
                        denda: isNaN(selectedItem.denda) ? selectedItem.denda : 'Rp ' + parseInt(selectedItem.denda)
                            .toLocaleString('id-ID') + '/jam',
                        lokasi: selectedItem.loc
                    }
                };

                // Daftarkan manifest object ke localStorage
                localStorage.setItem('publishedItem', JSON.stringify(productData));

                // Arahkan ke route halaman edit item Laravel Anda
                window.location.href = '/katalog/edit-item/' + itemId;
            }

            function updatePagination(total) {
                const pag = document.querySelector('.katalog-pagination');
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
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                });

                pag.querySelector('.nav').addEventListener('click', () => {
                    if (currentPage < total) {
                        currentPage++;
                        renderPage(currentPage);
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
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

            // Search
            document.querySelector('.katalog-search input').addEventListener('input', function() {
                activeSearch = this.value.toLowerCase();
                currentPage = 1;
                renderPage(1);
            });

            // Profile stats otomatis mengikuti panjang data asli database
            document.getElementById('jumlahKatalog').textContent = katalogs.length + ' Barang';

            // Render awal
            renderPage(1);

            // Samakan tinggi add-card dengan kartu produk
            function equalizeCardHeight() {
                setTimeout(() => {
                    const productCard = document.querySelector('.katalog-card');
                    const addCard = document.querySelector('.add-item-card');
                    if (productCard && addCard) {
                        addCard.style.minHeight = productCard.offsetHeight + 'px';
                    }
                }, 50);
            }
        </script>
    </x-slot:scripts>
</x-layout>
