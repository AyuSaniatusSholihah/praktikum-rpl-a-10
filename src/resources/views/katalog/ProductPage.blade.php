<x-layout title="Katalog Produk — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/minicart.css') }}" />
    </x-slot:styles>

    <section class="product-detail-page">
        <div class="container" style="max-width:1280px;">
            <div class="product-detail-grid">

                <div class="product-image-col">
                    <div class="product-main-img">
                        <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="ALLTREK Tenda Camping" />
                    </div>

                    <div class="gallery-thumbs">
                        <button class="thumb active" data-img="{{ asset('assets/img/tenda altrek.webp') }}">
                            <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="Foto 1" />
                        </button>
                        <button class="thumb" data-img="{{ asset('assets/img/tenda altrek.webp') }}">
                            <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="Foto 2" />
                        </button>
                        <button class="thumb" data-img="{{ asset('assets/img/tenda altrek.webp') }}">
                            <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="Foto 3" />
                        </button>
                        <button class="thumb" data-img="{{ asset('assets/img/tenda altrek.webp') }}">
                            <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="Foto 4" />
                        </button>
                        <button class="thumb" data-img="{{ asset('assets/img/tenda altrek.webp') }}">
                            <img src="{{ asset('assets/img/tenda altrek.webp') }}" alt="Foto 5" />
                        </button>
                    </div>

                    <div class="product-tabs">
                        <button class="product-tab active" data-tab="desc">Description</button>
                        <button class="product-tab" data-tab="info">Additional Information</button>
                        <button class="product-tab" data-tab="rev">Reviews [5]</button>
                    </div>

                    <p class="tab-content" id="tabContent">
                        Tenda yang cocok untuk kalian yang ingin mencoba camping bersama keluarga!
                        Tentastic merupakan tenda keluarga yang terdiri atas 2 ruangan (Living Room
                        dan Bedroom) dan bedroomnya dapat dibagi jadi 2 bedroom terpisah (untuk
                        varian large). Tentastic memiliki material yang terbuat dari Oxford Waterproof
                        PU 4500MM dan flooring Oxford 150D Seam Sealed, sehingga camping tetap
                        aman dan nyaman selama pemakaian! Dengan tingginya yang mencapai
                        180cm+, sehingga beraktivitas di dalam tenda tanpa khawatir! Camping
                        dimanapun aman, nyaman, dan cocok!
                    </p>

                    <button class="btn-read-more">Read more</button>
                </div>

                <div class="product-detail-col">
                    <div class="brand-label">SEWAIN</div>

                    <h1 class="product-title">ALLTREK Tenda Camping Tentastic Outdoor 1 Bedroom + 1 Guest Room</h1>

                    <div class="product-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="review-count">(4)</span>
                    </div>

                    <div class="viewing-now">
                        <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.7693 5.56008C17.8115 2.23779 14.1601 0.017334 10 0.017334C5.83821 0.017334 2.18766 2.23935 0.23078 5.56008C0.0796862 5.81647 0 6.10864 0 6.40624C0 6.70384 0.0796862 6.99601 0.23078 7.2524C2.18859 10.5747 5.83995 12.7951 10 12.7951C14.1618 12.7951 17.8124 10.5731 19.7693 7.25237C19.9203 6.99598 20 6.70382 20 6.40622C20 6.10863 19.9203 5.81646 19.7693 5.56008ZM10 11.1284C6.43904 11.1284 3.33019 9.22911 1.66668 6.40622C3.19991 3.80438 5.96102 1.98713 9.17231 1.71848C9.51245 2.06865 9.72224 2.54615 9.72224 3.07289C9.72224 4.14678 8.85168 5.01733 7.77779 5.01733C6.70391 5.01733 5.83335 4.14678 5.83335 3.07289L5.83338 3.07143C5.47898 3.7341 5.27779 4.49108 5.27779 5.29511C5.27779 7.90313 7.392 10.0173 10 10.0173C12.608 10.0173 14.7222 7.90313 14.7222 5.29511C14.7222 4.21765 14.3611 3.22466 13.7537 2.43001C15.6842 3.23393 17.292 4.63907 18.3334 6.40622C16.6699 9.22911 13.561 11.1284 10 11.1284Z" fill="#8A8A8A" stroke="#8A8A8A" stroke-width="0.0347222" />
                        </svg>
                        <span>24 people are viewing this right now</span>
                    </div>

                    <div class="product-price-row">
                        <span class="price">Rp 450.000/hari</span>
                        <span class="price-old">Rp 500.000</span>
                    </div>

                    <div class="date-row">
                        <div class="date-box">
                            <div class="date-label">Tanggal Mulai Penyewaan</div>
                            <div class="date-value">
                                <div class="date-icon-wrap">
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                                        <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.8043C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18" />
                                    </svg>
                                    <input type="date" class="date-hidden" id="dateStart" />
                                </div>
                                <span id="displayStart"></span>
                            </div>
                        </div>
                        <div class="date-box">
                            <div class="date-label">Tanggal Selesai Penyewaan</div>
                            <div class="date-value">
                                <div class="date-icon-wrap">
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                                        <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.8043C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18" />
                                    </svg>
                                    <input type="date" class="date-hidden" id="dateEnd" />
                                </div>
                                <span id="displayEnd"></span>
                            </div>
                        </div>
                    </div>

                    <div class="stock-row">
                        <div class="stock-text">Only <strong>9</strong> item(s) left in stock!</div>
                        <div class="stock-bar">
                            <div class="stock-bar-fill"></div>
                        </div>
                    </div>

                    <div class="qty-section">
                        <div class="qty-label">Quantity</div>
                        <div class="qty-controls">
                            <div class="qty-input">
                                <button class="qty-btn" id="qtyMinus">−</button>
                                <span class="qty-num" id="qtyNum">1</span>
                                <button class="qty-btn" id="qtyPlus">+</button>
                            </div>
                            <button class="btn-add-cart">Add to cart</button>
                            <button class="btn-rent-now">Rent Now!</button>
                        </div>
                    </div>

                    <div class="action-links">
                        <a href="#" aria-label="Compare">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="17 1 21 5 17 9" />
                                <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                                <polyline points="7 23 3 19 7 15" />
                                <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                            </svg>
                            Compare
                        </a>
                        <a href="#" aria-label="Ask a question">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            Ask a question
                        </a>
                        <a href="#" aria-label="Share">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18" cy="5" r="3" />
                                <circle cx="6" cy="12" r="3" />
                                <circle cx="18" cy="19" r="3" />
                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                            </svg>
                            Share
                        </a>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0; stroke:none;">
                                <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.8043C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18" />
                            </svg>
                            <span><strong>Available Dates:</strong> May 30 2026 - 2027</span>
                        </div>
                        <div class="info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            <span><strong>Return Policy:</strong> On-time return required</span>
                        </div>
                        <div class="info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            <span><strong>Late Fee Applied for Delays</strong></span>
                        </div>
                    </div>

                    <div class="payment-box">
                        <div class="payment-icons">
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/visa.png" style="height:24px; width:auto; object-fit:contain;" alt="Visa" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/mastercard.png" style="height:28px; width:auto; object-fit:contain;" alt="Mastercard" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/amex.png" style="height:28px; width:auto; object-fit:contain;" alt="Amex" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/jcb.png" style="height:28px; width:auto; object-fit:contain;" alt="JCB" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/discover.png" style="height:28px; width:auto; object-fit:contain;" alt="Discover" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/paypal.png" style="height:28px; width:auto; object-fit:contain;" alt="PayPal" /></div>
                            <div class="pay-wrap"><img src="https://img.icons8.com/color/48/bank-card-front-side.png" style="height:28px; width:auto; object-fit:contain;" alt="Card" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/bca.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="BCA" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/bni.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="BNI" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/mandiri.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="Mandiri" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/bri.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="BRI" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/bsi.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="BSI" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/gopay.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="GoPay" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/ovo.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="OVO" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/dana.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="DANA" /></div>
                            <div class="pay-wrap"><img src="{{ asset('assets/img/spay.png') }}" style="height:28px; width:auto; object-fit:contain;" alt="ShopeePay" /></div>
                        </div>
                        <div class="guarantee-text">Guarantee safe &amp; secure checkout</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="minicart-backdrop" id="minicartBackdrop"></div>

    <aside class="minicart-sidebar" id="minicartSidebar" role="dialog" aria-label="Shopping Cart">
        <div class="minicart-header">
            <h2 class="minicart-title">Shopping Cart</h2>
            <button class="minicart-close" id="closeMinicart" aria-label="Close">×</button>
        </div>
        <div class="minicart-items" id="minicartItems"></div>
        <div class="minicart-wrap-option">
            <label>
                <input type="checkbox" id="wrapOption" />
                <span>For <strong>$10.00</strong> Please Wrap The Product</span>
            </label>
        </div>
        <div class="minicart-footer">
            <div class="minicart-subtotal">
                <span class="label">Subtotal</span>
                <strong class="amount" id="subtotalAmount">Rp 0</strong>
            </div>
            <button class="minicart-checkout" onclick="
                localStorage.removeItem('checkoutCart');
                location.href='{{ route('checkout') }}';
            ">Checkout</button>
            <a href="{{ route('cart') }}" class="minicart-viewcart">View Cart</a>
        </div>
    </aside>

    <x-slot:scripts>
        <script>
            /* ============ LOCALSTORAGE PREPARATION ============ */
            const saved = JSON.parse(localStorage.getItem('publishedItem') || '{}');

            const productData = {
                stok: (saved.stok > 0) ? saved.stok : 9,
                stokMax: (saved.stokMax > 0) ? saved.stokMax : 20,
                tglMulai: saved.tglMulai || '2026-05-30',
                tglSelesai: saved.tglSelesai || '2027-05-30',
            };

            const productInfo = {
                spesifikasi: saved.spesifikasi?.length ? saved.spesifikasi : [
                    { label: 'Kode', nilai: 'Tentastic PRO' },
                    { label: 'Brand', nilai: 'ALLTREK' },
                    { label: 'Material', nilai: '210D Oxford Waterproof PU 4500MM' },
                    { label: 'Ukuran', nilai: '380 x 260 x 185 cm' },
                ],
                pemilik: {
                    nama: saved.pemilik?.nama || 'Camping Groups Bandung',
                    wa: saved.pemilik?.wa || '6285390176483',
                    jaminan: saved.pemilik?.jaminan || 'KTP, SIM, + setengah harga asli',
                    denda: saved.pemilik?.denda || 'Rp 15.000/jam',
                    lokasi: saved.pemilik?.lokasi || 'Jl. Ir. H. Juanda No. 50 (Dago), Bandung',
                }
            };

            // Formatting ID-ID local dates display
            document.getElementById('displayStart').textContent =
                new Date(productData.tglMulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('displayEnd').textContent =
                new Date(productData.tglSelesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            /* ============ QUANTITY COMPONENT ============ */
            let qty = 1;
            const qtyNum = document.getElementById('qtyNum');
            document.getElementById('qtyMinus').addEventListener('click', () => {
                if (qty > 1) { qty--; qtyNum.textContent = qty; }
            });
            document.getElementById('qtyPlus').addEventListener('click', () => {
                if (qty < productData.stok) { qty++; qtyNum.textContent = qty; }
            });

            /* ============ STOCK INDICATOR ============ */
            document.querySelector('.stock-text').innerHTML = `Only <strong>${productData.stok}</strong> item(s) left in stock!`;
            const persen = Math.min((productData.stok / productData.stokMax) * 100, 100);
            document.querySelector('.stock-bar-fill').style.width = persen + '%';

            /* ============ RENDER DATES SPECIFICATION ============ */
            const tglMulaiDisplay = new Date(productData.tglMulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const tglSelesaiDisplay = new Date(productData.tglSelesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.querySelector('.info-item span').innerHTML = `<strong>Available Dates:</strong> ${tglMulaiDisplay} - ${tglSelesaiDisplay}`;
            document.getElementById('dateStart').min = productData.tglMulai;
            document.getElementById('dateStart').max = productData.tglSelesai;
            document.getElementById('dateEnd').min = productData.tglMulai;
            document.getElementById('dateEnd').max = productData.tglSelesai;

            /* ============ REVIEWS COMPONENT ============ */
            const reviews = [
                { nama: 'Andi R.', foto: 'https://randomuser.me/api/portraits/men/32.jpg', tanggal: '21 Juli 2026', bintang: 5, isi: 'Tenda kualitas premium, set up gampang banget! Sangat direkomendasikan untuk camping keluarga.' },
                { nama: 'Sari M.', foto: 'https://randomuser.me/api/portraits/women/44.jpg', tanggal: '20 Juli 2026', bintang: 4, isi: 'Cukup luas untuk 4 orang, tahan hujan. Pemilik juga responsif dan ramah.' },
                { nama: 'Reza P.', foto: 'https://randomuser.me/api/portraits/men/67.jpg', tanggal: '15 Juli 2026', bintang: 5, isi: 'Worth it dengan harga sewanya. Highly recommended untuk kalian yang mau camping bareng keluarga!' },
            ];

            const avgRating = reviews.reduce((sum, r) => sum + r.bintang, 0) / reviews.length;
            const fullStars = Math.round(avgRating);
            document.querySelector('.stars').textContent = '★'.repeat(fullStars) + '☆'.repeat(5 - fullStars);
            document.querySelector('.review-count').textContent = `(${reviews.length})`;
            document.querySelector('[data-tab="rev"]').textContent = `Reviews [${reviews.length}]`;

            /* ============ RANDOMIZED REALTIME VIEWER ============ */
            const viewing = Math.floor(Math.random() * 20) + 5;
            document.querySelector('.viewing-now span').textContent = `${viewing} people are viewing this right now`;

            /* ============ IMAGE GALLERY GENERATOR ============ */
            const photos = [
                "{{ asset('assets/img/tenda altrek.webp') }}",
                "{{ asset('assets/img/tenda altrek.webp') }}",
                "{{ asset('assets/img/tenda altrek.webp') }}",
                "{{ asset('assets/img/tenda altrek.webp') }}",
                "{{ asset('assets/img/tenda altrek.webp') }}",
            ];
            const thumbsContainer = document.querySelector('.gallery-thumbs');
            thumbsContainer.innerHTML = photos.map((src, i) => `
                <button class="thumb ${i === 0 ? 'active' : ''}" data-img="${src}">
                    <img src="${src}" alt="Foto ${i+1}"/>
                </button>
            `).join('');
            document.querySelector('.product-main-img img').src = photos[0];

            thumbsContainer.addEventListener('click', (e) => {
                const th = e.target.closest('.thumb');
                if (!th) return;
                document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
                th.classList.add('active');
                document.querySelector('.product-main-img img').src = th.dataset.img;
            });

            /* ============ DESCRIPTION & SPEC TABS HANDLING ============ */
            const tabContent = document.getElementById('tabContent');

            const tabs = {
                desc: `Tenda yang cocok untuk kalian yang ingin mencoba camping bersama keluarga! Tentastic merupakan tenda keluarga yang terdiri atas 2 ruangan (Living Room dan Bedroom) dan bedroomnya dapat dibagi jadi 2 bedroom terpisah (untuk varian large). Tentastic memiliki material yang terbuat dari Oxford Waterproof PU 4500MM dan flooring Oxford 150D Seam Sealed, sehingga camping tetap aman dan nyaman selama pemakaian!`,
                info: ``, 
                rev: ``   
            };

            tabs.rev = `<div style="display:flex;flex-direction:column;gap:0;">` +
                reviews.map((r, i) => `
                    <div style="display:flex;gap:12px;padding:16px 0;${i < reviews.length - 1 ? 'border-bottom:1px solid #f0f0f0' : ''}">
                        <div style="width:44px;height:44px;border-radius:50%;background:#d6d6d6;flex-shrink:0;overflow:hidden">
                            <img src="${r.foto}" style="width:100%;height:100%;object-fit:cover"/>
                        </div>
                        <div style="flex:1">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                                <div>
                                    <div style="font-family:'Volkhov',serif;font-weight:600;font-size:17px;color:#181A18">${r.nama}</div>
                                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:#181A18;opacity:0.5">Penyewa Terverifikasi</div>
                                </div>
                                <div style="text-align:right;">
                                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:#181A18;opacity:0.5;margin-bottom:2px">${r.tanggal}</div>
                                    <div style="color:#f5b800;font-size:16px;">${'★'.repeat(r.bintang)}${'☆'.repeat(5 - r.bintang)}</div>
                                </div>
                            </div>
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:#181A18;margin-top:6px;line-height:1.6">${r.isi}</div>
                        </div>
                    </div>
                `).join('') + `</div>`;

            tabs.info = `
                <table style="width:100%;font-family:'Lato',sans-serif;font-size:13px;margin-bottom:20px;">
                    ${productInfo.spesifikasi.map((s, i) => `
                        <tr>
                            <td style="color:#181A18;padding:6px 0;width:40%;${i > 0 ? 'border-top:1px solid #f0f0f0' : ''}">${s.label}</td>
                            <td style="text-align:right;font-weight:500;color:#181A18;${i > 0 ? 'border-top:1px solid #f0f0f0' : ''}">${s.nilai}</td>
                        </tr>
                    `).join('')}
                </table>
                <div style="background:#f5f5f5;border-radius:8px;padding:18px 20px;font-family:'Poppins',sans-serif;font-size:13px;display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Pemilik: <span style="font-weight:500">${productInfo.pemilik.nama}</span></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">WhatsApp: <span style="font-weight:500">${productInfo.pemilik.wa}</span></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Jaminan: <span style="font-weight:500">${productInfo.pemilik.jaminan}</span></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Denda: <span style="font-weight:500">${productInfo.pemilik.denda}</span></span>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Lokasi: <span style="font-weight:500">${productInfo.pemilik.lokasi}</span></span>
                    </div>
                </div>`;

            document.querySelectorAll('.product-tab').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.product-tab').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    tabContent.innerHTML = tabs[btn.dataset.tab];
                });
            });

            /* ============ TEXT CLAMP HANDLING (READ MORE) ============ */
            const btnReadMore = document.querySelector('.btn-read-more');
            let isExpanded = false;

            function applyClamp(content) {
                content.style.display = '-webkit-box';
                content.style.webkitBoxOrient = 'vertical';
                content.style.overflow = 'hidden';
                content.style.webkitLineClamp = '4';
            }

            function removeClamp(content) {
                content.style.display = 'block';
                content.style.overflow = 'visible';
                content.style.webkitLineClamp = 'unset';
            }

            function checkOverflow() {
                const content = document.getElementById('tabContent');
                isExpanded = false;
                btnReadMore.textContent = 'Read more';

                removeClamp(content);
                const fullHeight = content.scrollHeight;
                applyClamp(content);
                const clampedHeight = content.clientHeight;

                if (fullHeight > clampedHeight + 5) {
                    btnReadMore.style.display = 'inline-block';
                } else {
                    btnReadMore.style.display = 'none';
                }
            }

            btnReadMore.addEventListener('click', function() {
                const content = document.getElementById('tabContent');
                if (isExpanded) {
                    applyClamp(content);
                    this.textContent = 'Read more';
                    isExpanded = false;
                } else {
                    removeClamp(content);
                    this.textContent = 'Read less';
                    isExpanded = true;
                }
            });

            checkOverflow();

            document.querySelectorAll('.product-tab').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTimeout(checkOverflow, 50);
                });
            });

            /* ============ PICKER LIMITATION INTERACTION ============ */
            document.getElementById('dateStart').addEventListener('change', function() {
                const d = new Date(this.value);
                document.getElementById('displayStart').textContent =
                    d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                const nextDayStr = nextDay.toISOString().split('T')[0];
                document.getElementById('dateEnd').min = nextDayStr;

                const currentEnd = document.getElementById('dateEnd').value;
                if (currentEnd && currentEnd <= this.value) {
                    document.getElementById('dateEnd').value = '';
                    document.getElementById('displayEnd').textContent = '';
                }
            });
            
            document.getElementById('dateEnd').addEventListener('change', function() {
                const d = new Date(this.value);
                document.getElementById('displayEnd').textContent =
                    d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            });

            /* ============ CTA UTILITIES LINKS ============ */
            document.querySelector('[aria-label="Ask a question"]').addEventListener('click', (e) => {
                e.preventDefault();
                const waLink = `https://wa.me/${productInfo.pemilik.wa}?text=${encodeURIComponent('Halo, saya ingin bertanya tentang ALLTREK Tenda Camping')}`;
                window.open(waLink, '_blank');
            });

            document.querySelector('[aria-label="Share"]').addEventListener('click', (e) => {
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({ title: 'ALLTREK Tenda Camping — SEWAIN', url: window.location.href });
                } else {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link berhasil disalin!');
                }
            });

            /* ============ CART BASICS SYSTEM & ANIMATION ============ */
            document.querySelector('.btn-add-cart').addEventListener('click', () => {
                const tglMulai = document.getElementById('displayStart').textContent.trim();
                const tglSelesai = document.getElementById('displayEnd').textContent.trim();

                if (!tglMulai || !tglSelesai) {
                    alert('Pilih tanggal mulai dan selesai penyewaan dulu!');
                    return;
                }

                const item = {
                    id: 'alltrek-tentastic',
                    nama: document.querySelector('.product-title').textContent.trim(),
                    qty: qty,
                    harga: 450000,
                    img: document.querySelector('.product-main-img img').src,
                    tglMulai: tglMulai,
                    tglSelesai: tglSelesai,
                };
                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const existingIndex = cart.findIndex(c => c.id === item.id);
                if (existingIndex > -1) {
                    cart[existingIndex].qty += item.qty;
                } else {
                    cart.push(item);
                }
                localStorage.setItem('cart', JSON.stringify(cart));

                // Fly Element Animation Effect
                const imgEl = document.querySelector('.product-main-img img');
                const cartEl = document.querySelector('[aria-label="Cart"]') || document.getElementById('openMinicart');
                if (imgEl && cartEl) {
                    const imgRect = imgEl.getBoundingClientRect();
                    const cartRect = cartEl.getBoundingClientRect();

                    const flyEl = document.createElement('div');
                    flyEl.classList.add('fly-item');
                    flyEl.innerHTML = `<img src="${imgEl.src}" alt=""/>`;
                    flyEl.style.left = imgRect.left + imgRect.width / 2 - 30 + 'px';
                    flyEl.style.top = imgRect.top + imgRect.height / 2 - 30 + 'px';
                    document.body.appendChild(flyEl);

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            flyEl.style.left = cartRect.left + cartRect.width / 2 - 10 + 'px';
                            flyEl.style.top = cartRect.top + cartRect.height / 2 - 10 + 'px';
                            flyEl.classList.add('fly-go');
                        });
                    });

                    setTimeout(() => {
                        flyEl.remove();
                        cartEl.classList.add('cart-bounce');
                        const badge = cartEl.querySelector('.badge') || document.getElementById('cartBadge');
                        if (badge) badge.textContent = parseInt(badge.textContent || 0) + qty;
                        setTimeout(() => cartEl.classList.remove('cart-bounce'), 400);
                    }, 850);
                }
            });

            /* ============ STORAGE MANAGEMENT FOR DIRECT RENTAL ============ */
            document.querySelector('.btn-rent-now').addEventListener('click', () => {
                const tglMulai = document.getElementById('displayStart').textContent.trim();
                const tglSelesai = document.getElementById('displayEnd').textContent.trim();

                if (!tglMulai || !tglSelesai || tglMulai === '' || tglSelesai === '') {
                    alert('Pilih tanggal mulai dan selesai penyewaan dulu!');
                    return;
                }

                const item = {
                    id: 'alltrek-tentastic',
                    nama: document.querySelector('.product-title').textContent.trim(),
                    qty: qty,
                    harga: 450000,
                    img: document.querySelector('.product-main-img img').src,
                    tglMulai: tglMulai,
                    tglSelesai: tglSelesai,
                };
                sessionStorage.setItem('rentItem', JSON.stringify(item));
                location.href = '{{ route("checkout") }}';
            });

            /* ============ CART LOGIC IMPLEMENTATION ============ */
            const backdrop = document.getElementById('minicartBackdrop');
            const sidebar = document.getElementById('minicartSidebar');
            const openBtn = document.getElementById('openMinicart');
            const closeBtn = document.getElementById('closeMinicart');
            const itemsContainer = document.getElementById('minicartItems');
            const subtotalEl = document.getElementById('subtotalAmount');
            const wrapCb = document.getElementById('wrapOption');
            const cartBadge = document.getElementById('cartBadge');

            const SVG_REMOVE = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47727 0 0 4.47727 0 10C0 15.5227 4.47727 20 10 20C15.5227 20 20 15.5227 20 10C20 4.47727 15.5227 0 10 0ZM13.37 7.91545C13.5356 7.744 13.6272 7.51436 13.6252 7.276C13.6231 7.03764 13.5275 6.80963 13.3589 6.64107C13.1904 6.47252 12.9624 6.37691 12.724 6.37484C12.4856 6.37277 12.256 6.4644 12.0845 6.63L10 8.71455L7.91545 6.63C7.83159 6.54317 7.73128 6.47392 7.62037 6.42627C7.50946 6.37863 7.39016 6.35355 7.26946 6.3525C7.14875 6.35145 7.02904 6.37445 6.91731 6.42016C6.80559 6.46587 6.70409 6.53338 6.61873 6.61873C6.53338 6.70409 6.46587 6.80559 6.42016 6.91731C6.37445 7.02904 6.35145 7.14875 6.3525 7.26946C6.35355 7.39016 6.37863 7.50946 6.42627 7.62037C6.47392 7.73128 6.54317 7.83159 6.63 7.91545L8.71455 10L6.63 12.0845C6.54317 12.1684 6.47392 12.2687 6.42627 12.3796C6.37863 12.4905 6.35355 12.6098 6.3525 12.7305C6.35145 12.8513 6.37445 12.971 6.42016 13.0827C6.46587 13.1944 6.53338 13.2959 6.61873 13.3813C6.70409 13.4666 6.80559 13.5341 6.91731 13.5798C7.02904 13.6255 7.14875 13.6485 7.26946 13.6475C7.39016 13.6465 7.50946 13.6214 7.62037 13.5737C7.73128 13.5261 7.83159 13.4568 7.91545 13.37L10 11.2855L12.0845 13.37C12.256 13.5356 12.4856 13.6272 12.724 13.6252C12.9624 13.6231 13.1904 13.5275 13.3589 13.3589C13.5275 13.1904 13.6231 12.9624 13.6252 12.724C13.6272 12.4856 13.5356 12.256 13.37 12.0845L11.2855 10L13.37 7.91545Z" fill="#9F9F9F"/></svg>`;

            function getCart() { return JSON.parse(localStorage.getItem('cart') || '[]'); }
            function saveCart(cart) { localStorage.setItem('cart', JSON.stringify(cart)); }

            function renderMinicart() {
                const cart = getCart();
                itemsContainer.innerHTML = '';

                if (cart.length === 0) {
                    itemsContainer.innerHTML = `
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
                    el.dataset.index = index;
                    el.dataset.price = item.harga;
                    el.innerHTML = `
                        <div class="minicart-thumb">
                            ${item.label ? `<span class="thumb-label">${item.label}</span>` : ''}
                            <img src="${item.img || ''}" alt="${item.nama}"/>
                        </div>
                        <div class="minicart-info">
                            <h4 class="minicart-name">${item.nama}</h4>
                            <div class="minicart-price">Rp ${item.harga.toLocaleString('id-ID')}/Hari</div>
                            <div class="minicart-qty">
                                <button class="qty-minus" aria-label="Decrease">−</button>
                                <span class="qty-display">${String(item.qty).padStart(2, '0')}</span>
                                <button class="qty-plus" aria-label="Increase">+</button>
                            </div>
                        </div>
                        <button class="minicart-remove" aria-label="Remove">${SVG_REMOVE}</button>
                    `;

                    el.querySelector('.qty-minus').addEventListener('click', () => {
                        const cart = getCart();
                        if (cart[index].qty > 1) { cart[index].qty--; saveCart(cart); renderMinicart(); }
                    });
                    el.querySelector('.qty-plus').addEventListener('click', () => {
                        const cart = getCart();
                        if (cart[index].qty < 99) { cart[index].qty++; saveCart(cart); renderMinicart(); }
                    });

                    const display = el.querySelector('.qty-display');
                    display.addEventListener('click', () => {
                        display.contentEditable = 'true';
                        display.focus();
                        const range = document.createRange();
                        range.selectNodeContents(display);
                        window.getSelection().removeAllRanges();
                        window.getSelection().addRange(range);
                    });
                    display.addEventListener('blur', () => {
                        display.contentEditable = 'false';
                        let q = parseInt(display.textContent, 10);
                        if (isNaN(q) || q < 1) q = 1;
                        if (q > 99) q = 99;
                        const cart = getCart();
                        cart[index].qty = q;
                        saveCart(cart);
                        renderMinicart();
                    });
                    display.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') { e.preventDefault(); display.blur(); }
                    });

                    el.querySelector('.minicart-remove').addEventListener('click', () => {
                        const c = getCart();
                        const targetItem = c[index];

                        // UX Improvement: Disable btn & fade out
                        const removeBtn = el.querySelector('.minicart-remove');
                        removeBtn.disabled = true;
                        removeBtn.style.opacity = '0.5';
                        el.style.opacity = '0.5';
                        el.style.pointerEvents = 'none';

                        if (targetItem.cart_item_id) {
                            fetch(`/cart/${targetItem.cart_item_id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                            });
                        }
                        
                        el.style.transition = 'opacity .2s, transform .2s';
                        el.style.opacity = '0';
                        el.style.transform = 'translateX(20px)';
                        setTimeout(() => {
                            const cart = getCart();
                            cart.splice(index, 1);
                            saveCart(cart);
                            renderMinicart();
                        }, 200);
                    });

                    itemsContainer.appendChild(el);
                });
                recalc();
            }

            const existingCart = getCart();
            if (existingCart.length === 0) {
                saveCart([
                    { id: 'alltrek-tentastic', nama: 'ALLTREK Tenda Camping Tentastic Outdoor 1 Bedroom + 1 Guest Room', harga: 450000, qty: 1, img: "{{ asset('assets/img/tenda altrek.webp') }}", label: 'ALLTREK', tglMulai: '', tglSelesai: '' },
                    { id: 'kebaya-cream', nama: 'Kebaya Cream (1 Set)', harga: 630000, qty: 1, img: "{{ asset('assets/img/kebaya cream.jpg') }}", label: '', tglMulai: '', tglSelesai: '' }
                ]);
            }

            function recalc() {
                const cart = getCart();
                let total = 0;
                let count = 0;
                cart.forEach(item => {
                    total += item.harga * item.qty;
                    count += item.qty;
                });
                if (wrapCb && wrapCb.checked) total += 158000;
                if (subtotalEl) subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
                if (cartBadge) cartBadge.textContent = count;
            }

            function openMinicart() {
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

            if (openBtn) openBtn.addEventListener('click', (e) => { e.preventDefault(); openMinicart(); });
            closeBtn.addEventListener('click', closeMinicart);
            backdrop.addEventListener('click', closeMinicart);
            if (wrapCb) wrapCb.addEventListener('change', recalc);

            renderMinicart();
        </script>
    </x-slot:scripts>
</x-layout>