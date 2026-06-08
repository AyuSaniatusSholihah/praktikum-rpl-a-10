<x-layout title="{{ $product->nama_barang }} — SEWAIN">
    <x-slot:styles>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&family=Lato:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/product-rent.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/minicart.css') }}" />
        <style>
            /* Blur background saat minicart terbuka */
            body.minicart-open .product-detail-page { filter: blur(4px); transition: filter 0.3s ease; }
            .product-detail-page { transition: filter 0.3s ease; }
            /* Backdrop */
            .minicart-backdrop { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
            .minicart-backdrop.show { opacity: 1; pointer-events: auto; }
            /* Animasi gambar terbang ke cart */
            .fly-item { position:fixed; z-index:9999; border-radius:12px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,.15); pointer-events:none; transition:all 0.85s cubic-bezier(.25,1,.5,1); transform:scale(1); opacity:1; }
            .fly-item img { width:100%; height:100%; object-fit:cover; }
            .fly-go { transform:scale(0.1); opacity:0.2; }
            @keyframes cartBounce { 0%,100%{transform:scale(1)} 50%{transform:scale(1.3)} }
            .cart-bounce { animation:cartBounce 0.4s ease-in-out; }

            /* ===== TOAST NOTIFICATION ===== */
            #rentToast {
                position: fixed;
                bottom: 32px;
                left: 50%;
                transform: translateX(-50%) translateY(100px);
                z-index: 99999;
                display: flex;
                align-items: flex-start;
                gap: 14px;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 40px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.08);
                padding: 18px 24px 18px 20px;
                min-width: 320px;
                max-width: 420px;
                opacity: 0;
                transition: transform 0.4s cubic-bezier(.34,1.56,.64,1), opacity 0.4s ease;
                pointer-events: none;
            }
            #rentToast.show {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
                pointer-events: auto;
            }
            #rentToast .toast-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 20px;
            }
            #rentToast .toast-icon.warning  { background: #fff7ed; color: #f97316; }
            #rentToast .toast-icon.info     { background: #eff6ff; color: #3b82f6; }
            #rentToast .toast-icon.error    { background: #fef2f2; color: #ef4444; }
            #rentToast .toast-body { flex: 1; }
            #rentToast .toast-title {
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
                font-size: 15px;
                color: #181A18;
                margin-bottom: 4px;
            }
            #rentToast .toast-msg {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 13px;
                color: #555;
                line-height: 1.5;
            }
            #rentToast .toast-action {
                margin-top: 12px;
                display: inline-block;
                padding: 7px 18px;
                border-radius: 8px;
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                cursor: pointer;
                border: none;
            }
            #rentToast .toast-action.primary {
                background: #181A18;
                color: #fff;
            }
            #rentToast .toast-close {
                position: absolute;
                top: 12px;
                right: 14px;
                background: none;
                border: none;
                font-size: 18px;
                color: #aaa;
                cursor: pointer;
                line-height: 1;
                padding: 0;
            }
            #rentToast .toast-close:hover { color: #555; }
        </style>
    </x-slot:styles>

    {{-- ============ PRODUCT DETAIL ============ --}}
    <section class="product-detail-page">
        <div class="container" style="max-width:1280px;">
            <div class="product-detail-grid">

                {{-- LEFT: IMAGE + TABS --}}
                <div class="product-image-col">
                    <div class="product-main-img">
                        <img id="productMainImage"
                             src="{{ $product->foto_barang ? asset('storage/'.$product->foto_barang) : 'https://placehold.co/600x450?text=No+Image' }}"
                             alt="{{ $product->nama_barang }}"
                             onerror="this.src='https://placehold.co/600x450?text=No+Image'" />
                    </div>

                    <div class="gallery-thumbs">
                        {{-- Thumbnail utama --}}
                        <button class="thumb active"
                                data-img="{{ $product->foto_barang ? asset('storage/'.$product->foto_barang) : 'https://placehold.co/600x450?text=No+Image' }}">
                            <img src="{{ $product->foto_barang ? asset('storage/'.$product->foto_barang) : 'https://placehold.co/600x450?text=No+Image' }}"
                                 alt="Foto 1" />
                        </button>
                        {{-- Foto produk tambahan (angle 1-4) --}}
                        @foreach(array_filter([$product->fotoproduk1, $product->fotoproduk2, $product->fotoproduk3, $product->fotoproduk4]) as $i => $fotoTambahan)
                        <button class="thumb" data-img="{{ asset('storage/'.$fotoTambahan) }}">
                            <img src="{{ asset('storage/'.$fotoTambahan) }}" alt="Foto {{ $i + 2 }}" />
                        </button>
                        @endforeach
                    </div>

                    <div class="product-tabs">
                        <button class="product-tab active" data-tab="desc">Description</button>
                        <button class="product-tab" data-tab="info">Additional Information</button>
                        <button class="product-tab" data-tab="rev">Reviews [{{ $product->reviews->count() }}]</button>
                    </div>

                    <p class="tab-content" id="tabContent">{{ $product->deskripsi }}</p>
                    <button class="btn-read-more">Read more</button>
                </div>

                {{-- RIGHT: DETAILS --}}
                <div class="product-detail-col">
                    <div class="brand-label">SEWAIN</div>

                    <h1 class="product-title">{{ $product->nama_barang }}</h1>

                    <div class="product-rating">
                        <span class="stars">
                            @php $fullStars = (int) round($product->reviews->avg('bintang') ?? 0); @endphp
                            @for ($i = 1; $i <= 5; $i++){{ $i <= $fullStars ? '★' : '☆' }}@endfor
                        </span>
                        <span class="review-count">({{ $product->reviews->count() }})</span>
                    </div>

                    <div class="viewing-now">
                        <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.7693 5.56008C17.8115 2.23779 14.1601 0.017334 10 0.017334C5.83821 0.017334 2.18766 2.23935 0.23078 5.56008C0.0796862 5.81647 0 6.10864 0 6.40624C0 6.70384 0.0796862 6.99601 0.23078 7.2524C2.18859 10.5747 5.83995 12.7951 10 12.7951C14.1618 12.7951 17.8124 10.5731 19.7693 7.25237C19.9203 6.99598 20 6.70382 20 6.40622C20 6.10863 19.9203 5.81646 19.7693 5.56008ZM10 11.1284C6.43904 11.1284 3.33019 9.22911 1.66668 6.40622C3.19991 3.80438 5.96102 1.98713 9.17231 1.71848C9.51245 2.06865 9.72224 2.54615 9.72224 3.07289C9.72224 4.14678 8.85168 5.01733 7.77779 5.01733C6.70391 5.01733 5.83335 4.14678 5.83335 3.07289L5.83338 3.07143C5.47898 3.7341 5.27779 4.49108 5.27779 5.29511C5.27779 7.90313 7.392 10.0173 10 10.0173C12.608 10.0173 14.7222 7.90313 14.7222 5.29511C14.7222 4.21765 14.3611 3.22466 13.7537 2.43001C15.6842 3.23393 17.292 4.63907 18.3334 6.40622C16.6699 9.22911 13.561 11.1284 10 11.1284Z"
                                  fill="#8A8A8A" stroke="#8A8A8A" stroke-width="0.0347222"/>
                        </svg>
                        <span id="viewingNow"></span>
                    </div>

                    <div class="product-price-row">
                        <span class="price">Rp {{ number_format($product->harga_sewa, 0, ',', '.') }}/hari</span>
                    </div>

                    {{-- Tanggal sewa --}}
                    <div class="date-row">
                        <div class="date-box">
                            <div class="date-label">Tanggal Mulai Penyewaan</div>
                            <div class="date-value">
                                <div class="date-icon-wrap">
                                    <svg width="19" height="19" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                                        style="flex-shrink:0;">
                                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                                    </svg>
                                    <input type="date" class="date-hidden" id="dateStart"
                                           min="{{ $product->tanggal_item_mulai?->format('Y-m-d') }}"
                                           max="{{ $product->tanggal_item_tidak_tersedia?->format('Y-m-d') }}"
                                           value="{{ $product->tanggal_item_mulai?->format('Y-m-d') ?? now()->format('Y-m-d') }}" />
                                </div>
                                <span id="displayStart">
                                    {{ $product->tanggal_item_mulai
                                        ? \Carbon\Carbon::parse($product->tanggal_item_mulai)->translatedFormat('j F Y')
                                        : now()->translatedFormat('j F Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="date-box">
                            <div class="date-label">Tanggal Selesai Penyewaan</div>
                            <div class="date-value">
                                <div class="date-icon-wrap">
                                    <svg width="19" height="19" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                                        style="flex-shrink:0;">
                                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                                    </svg>
                                    <input type="date" class="date-hidden" id="dateEnd"
                                           min="{{ $product->tanggal_item_mulai?->format('Y-m-d') }}"
                                           max="{{ $product->tanggal_item_tidak_tersedia?->format('Y-m-d') }}"
                                           value="{{ $product->tanggal_item_tidak_tersedia?->format('Y-m-d') ?? now()->addDay()->format('Y-m-d') }}" />
                                </div>
                                <span id="displayEnd">
                                    {{ $product->tanggal_item_tidak_tersedia
                                        ? \Carbon\Carbon::parse($product->tanggal_item_tidak_tersedia)->translatedFormat('j F Y')
                                        : now()->addDay()->translatedFormat('j F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="stock-row">
                        <div class="stock-text">Only <strong>{{ $product->stok }}</strong> item(s) left in stock!</div>
                        <div class="stock-bar"><div class="stock-bar-fill" style="width:{{ $product->stok > 0 ? min(($product->stok / 10) * 100, 100) : 0 }}%"></div></div>
                    </div>

                    {{-- QUANTITY + TOMBOL --}}
                    <div class="qty-section" style="{{ (auth()->check() && (auth()->id() === $product->user_id || auth()->user()->role === 'admin')) ? 'justify-content: center;' : '' }}">
                        @if(auth()->check() && auth()->id() === $product->user_id)
                            <a href="{{ route('katalog.edit-item', $product->id) }}" class="btn-rent-now" style="width: 100%; text-align: center; background: #6A87A1; margin: 0 auto; max-width: 400px; display: flex; justify-content: center; align-items: center; font-size: 18px; font-weight: 700;">Edit Katalog</a>
                        @elseif(auth()->check() && auth()->user()->role === 'admin')
                            <div style="color: #727272; font-family: 'Poppins', sans-serif; font-size: 14px; text-align: center; width: 100%; padding: 12px; background: #f5f5f5; border-radius: 8px; font-weight: 500; border: 1px dashed #ccc;">
                                Anda masuk sebagai Admin. Mode tampilan saja, tidak dapat menyewa barang.
                            </div>
                        @else
                            <div class="qty-label">Quantity</div>
                            <div class="qty-controls">
                                <div class="qty-input">
                                    <button class="qty-btn" id="qtyMinus">−</button>
                                    <span class="qty-num" id="qtyNum">1</span>
                                    <button class="qty-btn" id="qtyPlus">+</button>
                                </div>

                                {{-- ADD TO CART: kirim AJAX ke controller, lalu buka minicart --}}
                                <button type="button" class="btn-add-cart" id="btnAddToCart">Add to cart</button>

                                {{-- RENT NOW: langsung ke checkout dengan id barang --}}
                                <a class="btn-rent-now" id="btnRentNow"
                                   href="{{ route('checkout', $product->id) }}">
                                   Rent Now!
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Flash error dari controller (misal owner coba add barang sendiri) --}}
                    @if(session('error'))
                        <div style="background:#fee2e2;border:1px solid #f87171;color:#b91c1c;padding:10px 14px;border-radius:8px;font-size:13px;margin-top:8px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="action-links">
                        <a href="#" aria-label="Compare">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                            Compare
                        </a>
                        <a href="https://wa.me/{{ $product->user->phone_number ?? '' }}?text={{ urlencode('Halo, saya ingin bertanya tentang ' . $product->nama_barang) }}"
                           target="_blank" aria-label="Ask a question">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Ask a question
                        </a>
                        <a href="#" id="shareBtn" aria-label="Share">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            Share
                        </a>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <span><strong>Available Dates:</strong>
                                {{ $product->tanggal_item_mulai
                                    ? \Carbon\Carbon::parse($product->tanggal_item_mulai)->translatedFormat('j F Y')
                                    : '-' }} –
                                {{ $product->tanggal_item_tidak_tersedia
                                    ? \Carbon\Carbon::parse($product->tanggal_item_tidak_tersedia)->translatedFormat('j F Y')
                                    : '-' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span><strong>Return Policy:</strong> On-time return required</span>
                        </div>
                        <div class="info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <span><strong>Late Fee Applied for Delays:</strong> Rp {{ number_format($product->harga_denda_perjam, 0, ',', '.') }}/jam</span>
                        </div>
                    </div>

                <div class="payment-box">
                    <div class="payment-icons">
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/visa.png" style="height:24px;width:auto;object-fit:contain;" alt="Visa"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/mastercard.png" style="height:28px;width:auto;object-fit:contain;" alt="Mastercard"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/amex.png" style="height:28px;width:auto;object-fit:contain;" alt="Amex"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/jcb.png" style="height:28px;width:auto;object-fit:contain;" alt="JCB"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/discover.png" style="height:28px;width:auto;object-fit:contain;" alt="Discover"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/paypal.png" style="height:28px;width:auto;object-fit:contain;" alt="PayPal"/></div>
                        <div class="pay-wrap"><img src="https://img.icons8.com/color/48/bank-card-front-side.png" style="height:28px;width:auto;object-fit:contain;" alt="Card"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/bca.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="BCA"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/bni.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="BNI"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/mandiri.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="Mandiri"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/bri.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="BRI"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/bsi.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="BSI"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/gopay.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="GoPay"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/ovo.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="OVO"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/dana.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="DANA"/></div>
                        <div class="pay-wrap"><img src="{{ asset('assets/img/spay.png') }}" style="height:28px;width:auto;object-fit:contain;" alt="ShopeePay"/></div>
                    </div>
                    <div class="guarantee-text">Guarantee safe &amp; secure checkout</div>
                </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============ MINICART SIDEBAR (embedded, bukan halaman terpisah) ============ --}}
    <div class="minicart-backdrop" id="minicartBackdrop"></div>

    <aside class="minicart-sidebar" id="minicartSidebar" role="dialog" aria-label="Shopping Cart">
        <div class="minicart-header">
            <h2 class="minicart-title">Shopping Cart</h2>
            <button class="minicart-close" id="closeMinicart" aria-label="Close">×</button>
        </div>

        <div class="minicart-items" id="minicartItems"></div>

        <div class="minicart-footer">
            <div class="minicart-subtotal">
                <span class="label">Subtotal</span>
                <strong class="amount" id="subtotalAmount">Rp 0</strong>
            </div>
            <button class="minicart-checkout" id="btnCheckoutFromCart">Checkout</button>
            <a href="{{ route('cart') }}" class="minicart-viewcart">View Cart</a>
        </div>
    </aside>

    <x-slot:scripts>
        <script>
        /* ============================================================
         * DATA PRODUK (dari Blade, tidak ada data dummy)
         * ============================================================ */
        const PRODUCT = {
            id      : {{ $product->id }},
            nama    : @json($product->nama_barang),
            harga   : {{ (int) $product->harga_sewa }},
            img     : @json($product->foto_barang ? asset('storage/'.$product->foto_barang) : 'https://placehold.co/400x300?text=No+Image'),
            stok    : {{ (int) $product->stok }},
        };

        const CSRF  = @json(csrf_token());
        const IS_LOGGED_IN   = {{ auth()->check() ? 'true' : 'false' }};
        const IS_OWN_PRODUCT = {{ (auth()->check() && auth()->id() === $product->user_id) ? 'true' : 'false' }};
        const LOGIN_URL      = "{{ route('login') }}";
        const ADD_CART_URL   = "{{ route('cart.add') }}";
        const CHECKOUT_URL   = "{{ route('checkout', $product->id) }}";
        const CART_PAGE_URL  = "{{ route('cart') }}";

        /* ============================================================
         * MINICART – ELEMENT REFS
         * ============================================================ */
        const backdrop   = document.getElementById('minicartBackdrop');
        const sidebar    = document.getElementById('minicartSidebar');
        const closeBtn   = document.getElementById('closeMinicart');
        const itemsCont  = document.getElementById('minicartItems');
        const subtotalEl = document.getElementById('subtotalAmount');
        // Icon cart di navbar (dari x-header)
        const cartBtn    = document.querySelector('[aria-label="Cart"]');
        const cartBadge  = document.getElementById('cartBadge') ?? cartBtn?.querySelector('.badge');

        /* ============================================================
         * MINICART – OPEN / CLOSE
         * ============================================================ */
        function openMinicart()  {
            backdrop.classList.add('show');
            sidebar.classList.add('show');
            document.body.classList.add('minicart-open');
            renderMinicart();
        }
        function closeMinicart() {
            backdrop.classList.remove('show');
            sidebar.classList.remove('show');
            document.body.classList.remove('minicart-open');
        }

        // Icon cart di navbar → buka sidebar (bukan navigasi ke halaman cart)
        if (cartBtn) {
            cartBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openMinicart();
            });
        }
        closeBtn.addEventListener('click', closeMinicart);
        backdrop.addEventListener('click', closeMinicart);

        // "Checkout" dari sidebar → ke checkout page
        document.getElementById('btnCheckoutFromCart').addEventListener('click', () => {
            window.location.href = CHECKOUT_URL;
        });

        /* ============================================================
         * MINICART – RENDER (baca dari localStorage)
         * ============================================================ */
        const SVG_REMOVE = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47727 0 0 4.47727 0 10C0 15.5227 4.47727 20 10 20C15.5227 20 20 15.5227 20 10C20 4.47727 15.5227 0 10 0ZM13.37 7.91545C13.5356 7.744 13.6272 7.51436 13.6252 7.276C13.6231 7.03764 13.5275 6.80963 13.3589 6.64107C13.1904 6.47252 12.9624 6.37691 12.724 6.37484C12.4856 6.37277 12.256 6.4644 12.0845 6.63L10 8.71455L7.91545 6.63C7.83159 6.54317 7.73128 6.47392 7.62037 6.42627C7.50946 6.37863 7.39016 6.35355 7.26946 6.3525C7.14875 6.35145 7.02904 6.37445 6.91731 6.42016C6.80559 6.46587 6.70409 6.53338 6.61873 6.61873C6.53338 6.70409 6.46587 6.80559 6.42016 6.91731C6.37445 7.02904 6.35145 7.14875 6.3525 7.26946C6.35355 7.39016 6.37863 7.50946 6.42627 7.62037C6.47392 7.73128 6.54317 7.83159 6.63 7.91545L8.71455 10L6.63 12.0845C6.54317 12.1684 6.47392 12.2687 6.42627 12.3796C6.37863 12.4905 6.35355 12.6098 6.3525 12.7305C6.35145 12.8513 6.37445 12.971 6.42016 13.0827C6.46587 13.1944 6.53338 13.2959 6.61873 13.3813C6.70409 13.4666 6.80559 13.5341 6.91731 13.5798C7.02904 13.6255 7.14875 13.6485 7.26946 13.6475C7.39016 13.6465 7.50946 13.6214 7.62037 13.5737C7.73128 13.5261 7.83159 13.4568 7.91545 13.37L10 11.2855L12.0845 13.37C12.256 13.5356 12.4856 13.6272 12.724 13.6252C12.9624 13.6231 13.1904 13.5275 13.3589 13.3589C13.5275 13.1904 13.6231 12.9624 13.6252 12.724C13.6272 12.4856 13.5356 12.256 13.37 12.0845L11.2855 10L13.37 7.91545Z" fill="#9F9F9F"/></svg>`;

        function getCart()       { return JSON.parse(localStorage.getItem('cart') || '[]'); }
        function saveCart(cart)  { localStorage.setItem('cart', JSON.stringify(cart)); }

        function recalc() {
            const cart = getCart();
            let total = 0, count = 0;
            cart.forEach(item => { total += item.harga * item.qty; count += item.qty; });
            if (subtotalEl)  subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            if (cartBadge)   cartBadge.textContent  = count;
        }

        function renderMinicart() {
            const cart = getCart();
            itemsCont.innerHTML = '';

            if (cart.length === 0) {
                itemsCont.innerHTML = `
                    <div class="minicart-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>
                        </svg>
                        <p>Keranjang kosong</p>
                    </div>`;
                recalc();
                return;
            }

            cart.forEach((item, index) => {
                const el = document.createElement('div');
                el.className = 'minicart-item';
                el.innerHTML = `
                    <div class="minicart-thumb">
                        <img src="${item.img || ''}" alt="${item.nama}"/>
                    </div>
                    <div class="minicart-info">
                        <h4 class="minicart-name">${item.nama}</h4>
                        <div class="minicart-price">Rp ${item.harga.toLocaleString('id-ID')}/Hari</div>
                        <div class="minicart-qty">
                            <button class="qty-minus">−</button>
                            <span class="qty-display">${String(item.qty).padStart(2,'0')}</span>
                            <button class="qty-plus">+</button>
                        </div>
                    </div>
                    <button class="minicart-remove">${SVG_REMOVE}</button>`;

                el.querySelector('.qty-minus').addEventListener('click', () => {
                    const c = getCart();
                    const targetItem = c[index];
                    if (targetItem.qty > 1) {
                        const newVal = targetItem.qty - 1;
                        if (targetItem.cart_item_id) {
                            fetch(`/cart/${targetItem.cart_item_id}/quantity`, {
                                method: 'PATCH',
                                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                                body: JSON.stringify({ quantity: newVal })
                            })
                            .then(res => {
                                if (!res.ok) return res.json().then(err => { throw err; });
                                return res.json();
                            })
                            .then(() => {
                                c[index].qty = newVal;
                                saveCart(c);
                                renderMinicart();
                            })
                            .catch(err => {
                                alert(err.error || 'Gagal mengubah kuantitas.');
                            });
                        } else {
                            c[index].qty--;
                            saveCart(c);
                            renderMinicart();
                        }
                    }
                });
                el.querySelector('.qty-plus').addEventListener('click', () => {
                    const c = getCart();
                    const targetItem = c[index];
                    const newVal = targetItem.qty + 1;
                    if (targetItem.cart_item_id) {
                        fetch(`/cart/${targetItem.cart_item_id}/quantity`, {
                            method: 'PATCH',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                            body: JSON.stringify({ quantity: newVal })
                        })
                        .then(res => {
                            if (!res.ok) return res.json().then(err => { throw err; });
                            return res.json();
                        })
                        .then(() => {
                            c[index].qty = newVal;
                            saveCart(c);
                            renderMinicart();
                        })
                        .catch(err => {
                            alert(err.error || 'Gagal mengubah kuantitas.');
                        });
                    } else {
                        c[index].qty++;
                        saveCart(c);
                        renderMinicart();
                    }
                });
                el.querySelector('.minicart-remove').addEventListener('click', () => {
                    const c = getCart();
                    const targetItem = c[index];
                    if (targetItem.cart_item_id) {
                        fetch(`/cart/${targetItem.cart_item_id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error();
                            c.splice(index, 1);
                            saveCart(c);
                            renderMinicart();
                        })
                        .catch(() => alert('Gagal menghapus barang dari keranjang.'));
                    } else {
                        c.splice(index, 1);
                        saveCart(c);
                        renderMinicart();
                    }
                });
                itemsCont.appendChild(el);
            });
            recalc();
        }

        /* ============================================================
         * ADD TO CART – AJAX + ANIMASI TERBANG + BUKA SIDEBAR
         * ============================================================ */
        let qty = 1;
        document.getElementById('qtyMinus')?.addEventListener('click', () => { if (qty > 1) { qty--; document.getElementById('qtyNum').textContent = qty; } });
        document.getElementById('qtyPlus')?.addEventListener('click',  () => { if (qty < PRODUCT.stok) { qty++; document.getElementById('qtyNum').textContent = qty; } });

        document.getElementById('btnAddToCart')?.addEventListener('click', function () {
            // Kasus 1: Belum login
            if (!IS_LOGGED_IN) {
                showRentToast({
                    iconClass   : 'info',
                    iconEmoji   : '🔐',
                    title       : 'Login Diperlukan',
                    msg         : 'Kamu perlu login terlebih dahulu sebelum menambahkan barang ke keranjang.',
                    actionLabel : 'Login Sekarang',
                    actionHref  : LOGIN_URL + '?redirect=' + encodeURIComponent(window.location.href),
                });
                return;
            }

            // Kasus 2: Produk milik sendiri
            if (IS_OWN_PRODUCT) {
                showRentToast({
                    iconClass   : 'warning',
                    iconEmoji   : '⚠️',
                    title       : 'Produk Milik Kamu',
                    msg         : 'Kamu tidak dapat menambahkan produk milikmu sendiri ke keranjang.',
                });
                return;
            }

            const startDate = document.getElementById('dateStart').value || @json($product->tanggal_item_mulai?->format('Y-m-d'));
            const endDate   = document.getElementById('dateEnd').value   || @json($product->tanggal_item_tidak_tersedia?->format('Y-m-d'));
            const imgEl     = document.getElementById('productMainImage');

            // Kirim ke backend via AJAX (simpan di database)
            fetch(ADD_CART_URL, {
                method : 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body   : JSON.stringify({ barang_id: PRODUCT.id, qty, start_date: startDate, end_date: endDate }),
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                // 1. Animasi gambar terbang ke cart icon
                if (imgEl && cartBtn) {
                    const imgRect  = imgEl.getBoundingClientRect();
                    const cartRect = cartBtn.getBoundingClientRect();
                    const flyEl    = document.createElement('div');
                    flyEl.className = 'fly-item';
                    flyEl.innerHTML = `<img src="${imgEl.src}" alt=""/>`;
                    flyEl.style.cssText = `left:${imgRect.left}px;top:${imgRect.top}px;width:${imgRect.width}px;height:${imgRect.height}px;`;
                    document.body.appendChild(flyEl);
                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        flyEl.style.left   = (cartRect.left + cartRect.width/2 - 15) + 'px';
                        flyEl.style.top    = (cartRect.top  + cartRect.height/2 - 15) + 'px';
                        flyEl.style.width  = '30px';
                        flyEl.style.height = '30px';
                        flyEl.classList.add('fly-go');
                    }));
                    setTimeout(() => { flyEl.remove(); cartBtn?.classList.add('cart-bounce'); }, 850);
                    setTimeout(() => cartBtn?.classList.remove('cart-bounce'), 1250);
                }

                // 2. Simpan ke localStorage (tampilan sidebar)
                const cart = getCart();
                const idx  = cart.findIndex(c => c.id === PRODUCT.id);
                if (idx > -1) {
                    cart[idx].qty += qty;
                    cart[idx].cart_item_id = data.cart_item_id;
                } else {
                    cart.push({ id: PRODUCT.id, nama: PRODUCT.nama, harga: PRODUCT.harga, img: PRODUCT.img, qty, cart_item_id: data.cart_item_id });
                }
                saveCart(cart);

                // 3. Update global navbar cart count badge if available
                if (cartBadge) {
                    const currentCount = parseInt(cartBadge.textContent || '0');
                    cartBadge.textContent = currentCount + qty;
                }

                // 4. Buka minicart sidebar setelah animasi selesai
                setTimeout(() => openMinicart(), 900);
            })
            .catch(err => {
                showRentToast({
                    iconClass: 'error',
                    iconEmoji: '❌',
                    title: 'Gagal Menambahkan',
                    msg: err.error || 'Terjadi kesalahan saat menambahkan barang ke keranjang.',
                });
            });
        });

        /* ============================================================
         * TOAST NOTIFICATION HELPER
         * ============================================================ */
        function showRentToast({ iconClass, iconEmoji, title, msg, actionLabel, actionHref, actionFn }) {
            // Hapus toast lama jika ada
            const old = document.getElementById('rentToast');
            if (old) old.remove();

            const toast = document.createElement('div');
            toast.id = 'rentToast';
            toast.style.position = 'fixed';
            toast.innerHTML = `
                <button class="toast-close" onclick="this.closest('#rentToast').remove()" aria-label="Tutup">×</button>
                <div class="toast-icon ${iconClass}">${iconEmoji}</div>
                <div class="toast-body">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${msg}</div>
                    ${actionLabel ? `<a class="toast-action primary" id="toastActionBtn" href="${actionHref || '#'}">${actionLabel}</a>` : ''}
                </div>
            `;
            document.body.appendChild(toast);

            if (actionFn) {
                toast.querySelector('#toastActionBtn')?.addEventListener('click', (e) => {
                    e.preventDefault();
                    actionFn();
                });
            }

            // Tampilkan dengan animasi
            requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));

            // Auto-dismiss setelah 6 detik (kecuali ada action)
            if (!actionLabel) {
                setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 400); }, 6000);
            }
        }

        /* ============================================================
         * RENT NOW – langsung ke checkout
         * ============================================================ */
        document.getElementById('btnRentNow')?.addEventListener('click', function (e) {
            e.preventDefault();

            // Kasus: Belum login
            if (!IS_LOGGED_IN) {
                showRentToast({
                    iconClass   : 'info',
                    iconEmoji   : '🔐',
                    title       : 'Login Diperlukan',
                    msg         : 'Kamu perlu login terlebih dahulu sebelum melakukan penyewaan.',
                    actionLabel : 'Login Sekarang',
                    actionHref  : LOGIN_URL + '?redirect=' + encodeURIComponent(window.location.href),
                });
                return;
            }

            // Kasus: Produk milik sendiri (hanya bisa terjadi kalau sudah login)
            if (IS_OWN_PRODUCT) {
                showRentToast({
                    iconClass   : 'warning',
                    iconEmoji   : '⚠️',
                    title       : 'Produk Milik Kamu',
                    msg         : 'Kamu tidak dapat menyewa produk milikmu sendiri. Silakan temukan produk lain di halaman Rentals.',
                    actionLabel : 'Lihat Produk Lain',
                    actionHref  : "{{ route('rentals') }}",
                });
                return;
            }

            const startDate = document.getElementById('dateStart').value || @json($product->tanggal_item_mulai?->format('Y-m-d'));
            const endDate   = document.getElementById('dateEnd').value   || @json($product->tanggal_item_tidak_tersedia?->format('Y-m-d'));

            // Kalau sudah login: tambah ke cart dulu, lalu redirect ke checkout
            fetch(ADD_CART_URL, {
                method : 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body   : JSON.stringify({ barang_id: PRODUCT.id, qty: 1, start_date: startDate, end_date: endDate }),
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                window.location.href = CHECKOUT_URL;
            })
            .catch(err => {
                showRentToast({
                    iconClass: 'error',
                    iconEmoji: '❌',
                    title: 'Gagal Menyewa',
                    msg: err.error || 'Terjadi kesalahan saat melanjutkan ke penyewaan.',
                });
            });

        });

        /* ============================================================
         * DATE PICKER
         * ============================================================ */
        function formatDate(val) {
            if (!val) return '';
            const d = new Date(val + 'T00:00:00');
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }
        document.getElementById('dateStart').addEventListener('change', function () {
            document.getElementById('displayStart').textContent = formatDate(this.value);
        });
        document.getElementById('dateEnd').addEventListener('change', function () {
            document.getElementById('displayEnd').textContent = formatDate(this.value);
        });

        /* ============================================================
         * TAB CONTENT
         * ============================================================ */
        const tabs = {
            desc : @json($product->deskripsi),
            info : `<div style="font-family:'Poppins',sans-serif;font-size:13px;display:flex;flex-direction:column;gap:12px;">
                        @if($product->additional_information)
                        <div style="background:#f5f5f5;border-radius:8px;padding:18px 20px;white-space:pre-wrap;line-height:1.7;">{{ $product->additional_information }}</div>
                        @else
                        <div style="color:#aaa;padding:8px 0;font-size:13px;">Belum ada informasi tambahan.</div>
                        @endif
                        <div style="background:#f5f5f5;border-radius:8px;padding:18px 20px;display:flex;flex-direction:column;gap:8px;">
                            <div style="font-weight:700;margin-bottom:4px;color:#333;">Informasi Pemilik</div>
                            <div><strong>Pemilik:</strong> {{ $product->user->name ?? '-' }}</div>
                            <div><strong>WhatsApp:</strong> {{ $product->user->phone_number ?? '-' }}</div>
                            <div><strong>Jaminan:</strong> Rp {{ number_format($product->harga_jaminan, 0, ',', '.') }}</div>
                            <div><strong>Denda:</strong> Rp {{ number_format($product->harga_denda_perjam, 0, ',', '.') }}/jam</div>
                            <div><strong>Lokasi:</strong> {{ $product->lokasi }}</div>
                        </div>
                    </div>`,
            rev  : `<div>@forelse($product->reviews as $r)
                        <div style="display:flex;gap:12px;padding:16px 0;{{ !$loop->last ? 'border-bottom:1px solid #f0f0f0' : '' }}">
                            <div style="width:44px;height:44px;border-radius:50%;background:#d6d6d6;flex-shrink:0;overflow:hidden">
                                <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode($r->user->name ?? 'U') }}" style="width:100%;height:100%;object-fit:cover"/>
                            </div>
                            <div style="flex:1">
                                <div style="font-weight:600">{{ $r->user->name ?? 'Anonim' }}</div>
                                <div style="font-size:12px;color:#888">{{ $r->created_at->translatedFormat('j F Y') }}</div>
                                <div style="color:#f5b800">{{ str_repeat('★', $r->bintang) . str_repeat('☆', 5-$r->bintang) }}</div>
                                <div style="font-size:13px;margin-top:4px">{{ $r->isi }}</div>
                            </div>
                        </div>
                    @empty<p style="color:#888;font-size:13px;padding:16px 0">Belum ada ulasan.</p>@endforelse</div>`
        };

        const tabContent = document.getElementById('tabContent');
        document.querySelectorAll('.product-tab').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.product-tab').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                tabContent.innerHTML = tabs[btn.dataset.tab];
                setTimeout(checkOverflow, 50);
            });
        });

        /* ============================================================
         * READ MORE
         * ============================================================ */
        const btnReadMore = document.querySelector('.btn-read-more');
        let isExpanded = false;
        function applyClamp(el) { el.style.display='-webkit-box'; el.style.webkitBoxOrient='vertical'; el.style.overflow='hidden'; el.style.webkitLineClamp='4'; }
        function removeClamp(el) { el.style.display='block'; el.style.overflow='visible'; el.style.webkitLineClamp='unset'; }
        function checkOverflow() {
            isExpanded = false; btnReadMore.textContent = 'Read more';
            removeClamp(tabContent);
            const full = tabContent.scrollHeight; applyClamp(tabContent);
            btnReadMore.style.display = full > tabContent.clientHeight + 5 ? 'inline-block' : 'none';
        }
        btnReadMore.addEventListener('click', function () {
            if (isExpanded) { applyClamp(tabContent); this.textContent='Read more'; }
            else            { removeClamp(tabContent); this.textContent='Read less'; }
            isExpanded = !isExpanded;
        });
        checkOverflow();

        /* ============================================================
         * THUMBNAIL SWITCH
         * ============================================================ */
        document.querySelector('.gallery-thumbs')?.addEventListener('click', e => {
            const th = e.target.closest('.thumb'); if (!th) return;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            th.classList.add('active');
            document.querySelector('.product-main-img img').src = th.dataset.img;
        });

        /* ============================================================
         * SHARE
         * ============================================================ */
        document.getElementById('shareBtn').addEventListener('click', e => {
            e.preventDefault();
            if (navigator.share) navigator.share({ title: document.title, url: window.location.href });
            else { navigator.clipboard.writeText(window.location.href); alert('Link berhasil disalin!'); }
        });

        /* ============================================================
         * VIEWING NOW
         * ============================================================ */
        document.getElementById('viewingNow').textContent = (Math.floor(Math.random() * 20) + 5) + ' people are viewing this right now';

        // Init localStorage from database on load if logged in
        @auth
            const dbCart = {!! json_encode(\App\Models\Keranjang::where('user_id', auth()->id())->with('barang')->get()->map(function($item) {
                return [
                    'id' => $item->barang_id,
                    'nama' => $item->barang->nama_barang,
                    'harga' => (int) $item->barang->harga_sewa,
                    'img' => $item->barang->foto_barang ? asset('storage/'.$item->barang->foto_barang) : 'https://placehold.co/400x300?text=No+Image',
                    'qty' => $item->jumlah,
                    'stok' => (int) $item->barang->stok,
                    'cart_item_id' => $item->id
                ];
            })->toArray()) !!};
            saveCart(dbCart);
        @else
            saveCart([]);
        @endauth

        /* Init recalc badge */
        recalc();

        /* ============================================================
         * REAL-TIME STOCK POLLING
         * Setiap 30 detik, ambil stok terbaru dari server lalu update UI
         * ============================================================ */
        const STOK_URL = '/product/{{ $product->id }}/stok';

        function updateStockUI(stok, status) {
            // Update PRODUCT.stok agar qty-plus juga ikut terbatas
            PRODUCT.stok = stok;

            // Update teks badge stok
            const stockTextEl = document.querySelector('.stock-text');
            if (stockTextEl) {
                if (stok <= 0) {
                    stockTextEl.innerHTML = '<strong>Stok habis!</strong>';
                } else {
                    stockTextEl.innerHTML = `Only <strong>${stok}</strong> item(s) left in stock!`;
                }
            }

            // Update progress bar stok
            const barFill = document.querySelector('.stock-bar-fill');
            if (barFill) {
                const pct = stok > 0 ? Math.min((stok / 10) * 100, 100) : 0;
                barFill.style.width = pct + '%';
            }

            // Clamp qty selector agar tidak melebihi stok baru
            if (qty > stok) {
                qty = Math.max(1, stok);
                const qtyNumEl = document.getElementById('qtyNum');
                if (qtyNumEl) qtyNumEl.textContent = qty;
            }

            // Disable/enable tombol Add to Cart & Rent Now
            const btnAdd  = document.getElementById('btnAddToCart');
            const btnRent = document.getElementById('btnRentNow');
            const outOfStock = (stok <= 0 || status === 'tidak_tersedia');
            if (btnAdd) {
                btnAdd.disabled = outOfStock;
                btnAdd.style.opacity = outOfStock ? '0.5' : '';
                btnAdd.style.cursor  = outOfStock ? 'not-allowed' : '';
                btnAdd.textContent   = outOfStock ? 'Stok Habis' : 'Add to cart';
            }
            if (btnRent) {
                if (outOfStock) {
                    btnRent.style.pointerEvents = 'none';
                    btnRent.style.opacity = '0.5';
                    btnRent.textContent = 'Stok Habis';
                } else {
                    btnRent.style.pointerEvents = '';
                    btnRent.style.opacity = '';
                    btnRent.textContent = 'Rent Now!';
                }
            }
        }

        function pollStock() {
            fetch(STOK_URL)
                .then(res => res.json())
                .then(data => updateStockUI(data.stok, data.status))
                .catch(() => { /* silent fail jika network error */ });
        }

        // Jalankan polling tiap 30 detik
        setInterval(pollStock, 30000);
        // Juga jalankan 1x saat halaman dimuat (agar langsung sinkron)
        pollStock();
        </script>
    </x-slot:scripts>
</x-layout>
