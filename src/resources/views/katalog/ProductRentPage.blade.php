<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>{{ $product->nama }} (Owner View) — SEWAIN</title>
 <link rel="preconnect" href="https://fonts.googleapis.com" />
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
 <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Pacifico&family=Poppins:wght@300;400;500;600;700&family=Vidaloka&family=Lato:wght@400;500;600;700&family=Volkhov:wght@400;500;550;700;800&display=swap" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&family=Jomolhari&family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Vidaloka&display=swap" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Lato:wght@400;700&family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />

 <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/css/product-rent.css') }}" />
</head>
<body>

<nav class="site-nav">
 <a href="{{ route('home') }}" class="site-logo">SEWA<span>IN</span></a>
 <ul class="site-nav-links">
   <li><a href="{{ route('home') }}">Home</a></li>
   <li><a href="{{ route('rentals') }}" class="active">Rentals</a></li>
   <li><a href="{{ route('katalog') }}">My Katalogs</a></li>
 </ul>
 <div class="site-nav-right">
   <a href="{{ route('profile') }}" class="icon-link" aria-label="Account">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
         d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
     </svg>
   </a>
   <a href="#" class="icon-link" aria-label="Notifications">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
         d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
     </svg>
     <span class="badge">{{ $notifCount ?? 0 }}</span>
   </a>
   <a href="{{ route('cart') }}" class="icon-link" aria-label="Cart">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
         d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
     </svg>
     <span class="badge">{{ $cartCount ?? 0 }}</span>
   </a>
 </div>
</nav>

<section class="product-detail-page">
 <div class="container" style="max-width:1280px;">
   <div class="product-detail-grid">

     <!-- ============ LEFT: IMAGE + TABS ============ -->
     <div class="product-image-col">
       <div class="product-main-img">
         <img src="{{ asset('storage/' . $product->foto_barang) }}" alt="{{ $product->nama }}" onerror="this.src='https://placehold.co/600x450?text=No+Image'"/>
       </div>

       <!-- Thumbnail -->
       <div class="gallery-thumbs">
         @if(!empty($product->fotos))
           @foreach($product->fotos as $i => $foto)
             <button class="thumb {{ $i === 0 ? 'active' : '' }}" data-img="{{ asset('storage/' . $foto->foto_barang) }}">
               <img src="{{ asset('storage/' . $foto->foto_barang) }}" alt="Foto {{ $i + 1 }}"/>
             </button>
           @endforeach
         @endif
       </div>

       <div class="product-tabs">
         <button class="product-tab active" data-tab="desc">Description</button>
         <button class="product-tab" data-tab="info">Additional Information</button>
         <button class="product-tab" data-tab="rev">Reviews [{{ $product->reviews->count() }}]</button>
       </div>

       <p class="tab-content" id="tabContent">{{ $product->deskripsi }}</p>

       <button class="btn-read-more">Read more</button>
     </div>

     <!-- ============ RIGHT: DETAILS ============ -->
     <div class="product-detail-col">

       

       <div class="brand-label">SEWAIN</div>

       <h1 class="product-title">{{ $product->nama }}</h1>

       <div class="product-rating">
         <span class="stars">
           @php $fullStars = round($product->reviews->avg('bintang') ?? 0); @endphp
           @for($i = 1; $i <= 5; $i++){{ $i <= $fullStars ? '★' : '☆' }}@endfor
         </span>
         <span class="review-count">({{ $product->reviews->count() }})</span>
       </div>

       <div class="viewing-now">
         <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
           <path d="M19.7693 5.56008C17.8115 2.23779 14.1601 0.017334 10 0.017334C5.83821 0.017334 2.18766 2.23935 0.23078 5.56008C0.0796862 5.81647 0 6.10864 0 6.40624C0 6.70384 0.0796862 6.99601 0.23078 7.2524C2.18859 10.5747 5.83995 12.7951 10 12.7951C14.1618 12.7951 17.8124 10.5731 19.7693 7.25237C19.9203 6.99598 20 6.70382 20 6.40622C20 6.10863 19.9203 5.81646 19.7693 5.56008ZM10 11.1284C6.43904 11.1284 3.33019 9.22911 1.66668 6.40622C3.19991 3.80438 5.96102 1.98713 9.17231 1.71848C9.51245 2.06865 9.72224 2.54615 9.72224 3.07289C9.72224 4.14678 8.85168 5.01733 7.77779 5.01733C6.70391 5.01733 5.83335 4.14678 5.83335 3.07289L5.83338 3.07143C5.47898 3.7341 5.27779 4.49108 5.27779 5.29511C5.27779 7.90313 7.392 10.0173 10 10.0173C12.608 10.0173 14.7222 7.90313 14.7222 5.29511C14.7222 4.21765 14.3611 3.22466 13.7537 2.43001C15.6842 3.23393 17.292 4.63907 18.3334 6.40622C16.6699 9.22911 13.561 11.1284 10 11.1284Z" fill="#8A8A8A" stroke="#8A8A8A" stroke-width="0.0347222"/>
         </svg>
         <span id="viewingNow"></span>
       </div>

       <div class="product-price-row">
         <span class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}/hari</span>
         @if($product->harga_coret)
           <span class="price-old">Rp {{ number_format($product->harga_coret, 0, ',', '.') }}</span>
         @endif
       </div>

       <div class="date-row">
         <div class="date-box">
           <div class="date-label">Tanggal Mulai Penyewaan</div>
           <div class="date-value">
             <div class="date-icon-wrap">
               <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                 <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
               </svg>
               <input type="date" class="date-hidden" id="dateStart"
                 min="{{ $product->tgl_mulai }}"
                 max="{{ $product->tgl_selesai }}"/>
             </div>
             <span id="displayStart">
               {{ \Carbon\Carbon::parse($product->tgl_mulai)->translatedFormat('j F Y') }}
             </span>
           </div>
         </div>
         <div class="date-box">
           <div class="date-label">Tanggal Selesai Penyewaan</div>
           <div class="date-value">
             <div class="date-icon-wrap">
               <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                 <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15 3.33317ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H14.1667V5.83317C14.1667 6.05418 14.0789 6.26615 13.9226 6.42243C13.7663 6.57871 13.5543 6.6665 13.3333 6.6665C13.1123 6.6665 12.9004 6.57871 12.7441 6.42243C12.5878 6.26615 12.5 6.05418 12.5 5.83317V4.99984H7.5V5.83317C7.5 6.05418 7.4122 6.26615 7.25592 6.42243C7.09964 6.57871 6.88768 6.6665 6.66667 6.6665C6.44565 6.6665 6.23369 6.57871 6.07741 6.42243C5.92113 6.26615 5.83333 6.05418 5.83333 5.83317V4.99984H5C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
               </svg>
               <input type="date" class="date-hidden" id="dateEnd"
                 min="{{ $product->tgl_mulai }}"
                 max="{{ $product->tgl_selesai }}"/>
             </div>
             <span id="displayEnd">
               {{ \Carbon\Carbon::parse($product->tgl_selesai)->translatedFormat('j F Y') }}
             </span>
           </div>
         </div>
       </div>

       <div class="stock-row">
         <div class="stock-text">Only <strong>{{ $product->stok }}</strong> item(s) left in stock!</div>
         <div class="stock-bar">
                       <div class="stock-bar-fill" style="width:{{ $product->stok_max ? ($product->stok / $product->stok_max) * 100 : 0 }}%"></div>
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
           <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
              @csrf
              <input type="hidden" name="barang_id" value="{{ $product->id }}" />
              <input type="hidden" name="qty" value="1" />
              <input type="hidden" name="start_date" value="{{ now()->format('Y-m-d') }}" />
              <input type="hidden" name="end_date" value="{{ now()->addDay()->format('Y-m-d') }}" />
              <button type="submit" class="btn-add-cart" onclick="event.stopPropagation()">Add to cart</button>
            </form>
           <button class="btn-rent-now" onclick="event.stopPropagation(); window.location.href='{{ route('checkout', $product->id) }}'">Rent Now!</button>
         </div>
       </div>

       <div class="action-links">
         <a href="{{ route('rentals') }}" class="btn-back">Back to Rentals</a>
         <a href="#" aria-label="Compare">
           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
           Compare
         </a>
         <a href="https://wa.me/{{ optional($product->pemilik)->no_wa ?? '' }}?text={{ urlencode('Halo, saya ingin bertanya tentang ' . $product->nama) }}" target="_blank" aria-label="Ask a question">
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
           <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;stroke:none;">
             <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15 3.33317Z" fill="#181A18"/>
           </svg>
           <span>
             <strong>Available Dates:</strong>
             {{ \Carbon\Carbon::parse($product->tgl_mulai)->translatedFormat('j F Y') }} -
             {{ \Carbon\Carbon::parse($product->tgl_selesai)->translatedFormat('j F Y') }}
           </span>
         </div>
         <div class="info-item">
           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
           <span><strong>Return Policy:</strong> {{ $product->kebijakan_pengembalian }}</span>
         </div>
         <div class="info-item">
           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
           <span><strong>Denda Keterlambatan:</strong> {{ $product->pemilik->denda ?? '-' }}</span>
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

<script>
  /* ============ TAB CONTENT (rendered server-side, no dummy) ============ */
  const tabs = {
    desc: @json($product->deskripsi),
    info: `
<table style="width:100%;font-family:'Lato',sans-serif;font-size:13px;margin-bottom:20px;">
@if(!empty($product->spesifikasis))
@foreach($product->spesifikasis as $i => $spec)
  <tr>
    <td style="color:#181A18;padding:6px 0;width:40%;{{ $i > 0 ? 'border-top:1px solid #f0f0f0' : '' }}">{{ $spec->label }}</td>
    <td style="text-align:right;font-weight:500;color:#181A18;{{ $i > 0 ? 'border-top:1px solid #f0f0f0' : '' }}">{{ $spec->nilai }}</td>
  </tr>
@endforeach
@endif
</table>
<div style="background:#f5f5f5;border-radius:8px;padding:18px 20px;font-family:'Poppins',sans-serif;font-size:13px;display:flex;flex-direction:column;gap:10px;">
   <div><span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Pemilik: <span style="font-weight:500">{{ optional($product->pemilik)->nama ?? '' }}</span></span></div>
   <div><span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">WhatsApp: <span style="font-weight:500">{{ optional($product->pemilik)->no_wa ?? '' }}</span></span></div>
   <div><span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Jaminan: <span style="font-weight:500">{{ optional($product->pemilik)->jaminan ?? '' }}</span></span></div>
   <div><span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Denda: <span style="font-weight:500">{{ optional($product->pemilik)->denda ?? '' }}</span></span></div>
   <div><span style="font-family:'Volkhov',serif;font-size:17px;font-weight:700;">Lokasi: <span style="font-weight:500">{{ optional($product->pemilik)->lokasi ?? '' }}</span></span></div>
</div>`,

    rev: `<div style="display:flex;flex-direction:column;gap:0;">
      @forelse($product->reviews as $r)
        <div style="display:flex;gap:12px;padding:16px 0;{{ !$loop->last ? 'border-bottom:1px solid #f0f0f0' : '' }}">
          <div style="width:44px;height:44px;border-radius:50%;background:#d6d6d6;flex-shrink:0;overflow:hidden">
            <img src="{{ $r->user->foto ? asset('storage/' . $r->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($r->user->nama) }}" style="width:100%;height:100%;object-fit:cover"/>
          </div>
          <div style="flex:1">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
              <div>
                <div style="font-family:'Volkhov',serif;font-weight:600;font-size:17px;color:#181A18">{{ $r->user->nama }}</div>
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:#181A18;opacity:0.5">Penyewa Terverifikasi</div>
              </div>
              <div style="text-align:right;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:#181A18;opacity:0.5;margin-bottom:2px">{{ $r->created_at->translatedFormat('j F Y') }}</div>
                <div style="color:#f5b800;font-size:16px;">{{ str_repeat('★', $r->bintang) . str_repeat('☆', 5 - $r->bintang) }}</div>
              </div>
            </div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:#181A18;margin-top:6px;line-height:1.6">{{ $r->isi }}</div>
          </div>
        </div>
      @empty
        <p style="color:#888;font-size:13px;padding:16px 0;">Belum ada ulasan.</p>
      @endforelse
    </div>`
  };

  /* ============ VIEWING NOW (client-side random) ============ */
  document.getElementById('viewingNow').textContent =
    (Math.floor(Math.random() * 20) + 5) + ' people are viewing this right now';

  /* ============ TABS ============ */
  const tabContent = document.getElementById('tabContent');

  document.querySelectorAll('.product-tab').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.product-tab').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      tabContent.innerHTML = tabs[btn.dataset.tab];
      setTimeout(checkOverflow, 50);
    });
  });

  /* ============ READ MORE ============ */
  const btnReadMore = document.querySelector('.btn-read-more');
  let isExpanded = false;

  function applyClamp(el) {
    el.style.display = '-webkit-box';
    el.style.webkitBoxOrient = 'vertical';
    el.style.overflow = 'hidden';
    el.style.webkitLineClamp = '4';
  }
  function removeClamp(el) {
    el.style.display = 'block';
    el.style.overflow = 'visible';
    el.style.webkitLineClamp = 'unset';
  }
  function checkOverflow() {
    isExpanded = false;
    btnReadMore.textContent = 'Read more';
    removeClamp(tabContent);
    const full = tabContent.scrollHeight;
    applyClamp(tabContent);
    btnReadMore.style.display = full > tabContent.clientHeight + 5 ? 'inline-block' : 'none';
  }

  btnReadMore.addEventListener('click', function () {
    if (isExpanded) { applyClamp(tabContent); this.textContent = 'Read more'; }
    else            { removeClamp(tabContent); this.textContent = 'Read less'; }
    isExpanded = !isExpanded;
  });
  checkOverflow();

  /* ============ THUMBNAIL SWITCH ============ */
  document.querySelector('.gallery-thumbs').addEventListener('click', e => {
    const th = e.target.closest('.thumb');
    if (!th) return;
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    th.classList.add('active');
    document.querySelector('.product-main-img img').src = th.dataset.img;
  });

  /* ============ QTY ============ */
  const qtyNum = document.getElementById('qtyNum');
  document.getElementById('qtyMinus').addEventListener('click', () => {
    if (+qtyNum.textContent > 1) qtyNum.textContent = +qtyNum.textContent - 1;
  });
  document.getElementById('qtyPlus').addEventListener('click', () => {
    qtyNum.textContent = +qtyNum.textContent + 1;
  });

  /* ============ DATE PICKER DISPLAY ============ */
  ['dateStart', 'dateEnd'].forEach((id, i) => {
    document.getElementById(id).addEventListener('change', function () {
      const displayId = i === 0 ? 'displayStart' : 'displayEnd';
      if (this.value) {
        document.getElementById(displayId).textContent =
          new Date(this.value).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
      }
    });
  });

  /* ============ SHARE ============ */
  document.getElementById('shareBtn').addEventListener('click', e => {
    e.preventDefault();
    if (navigator.share) {
      navigator.share({ title: document.title, url: window.location.href });
    } else {
      navigator.clipboard.writeText(window.location.href);
      alert('Link berhasil disalin!');
    }
  });
</script>

<footer class="site-footer">
 <div class="site-footer-inner">
   <div class="site-footer-brand">
     <div class="site-footer-logo">SEWA<span>IN</span></div>
     <p class="site-footer-tagline">We help you find<br/>and rent what you<br/>need easily</p>
     <div class="site-footer-socials">
       <a href="#" aria-label="WhatsApp">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.558 4.126 1.534 5.857L0 24l6.302-1.513A11.934 11.934 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.891 0-3.665-.523-5.181-1.434l-.371-.219-3.742.898.939-3.635-.242-.386A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
       </a>
       <a href="#" aria-label="Instagram">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
       </a>
       <a href="#" aria-label="Globe">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
       </a>
       <a href="#" aria-label="Email">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
       </a>
     </div>
   </div>

   <div class="site-footer-cols">
     <div class="site-footer-col">
       <h4>Information</h4>
       <ul><li><a href="#">About</a></li><li><a href="#">Product</a></li><li><a href="#">Blog</a></li></ul>
     </div>
     <div class="site-footer-col">
       <h4>Company</h4>
       <ul><li><a href="#">Community</a></li><li><a href="#">Career</a></li><li><a href="#">Our Story</a></li></ul>
     </div>
     <div class="site-footer-col">
       <h4>Contact</h4>
       <ul><li><a href="#">Getting Started</a></li><li><a href="#">Pricing</a></li><li><a href="#">Resources</a></li></ul>
     </div>
   </div>
 </div>
 <div class="site-footer-bottom">
   Copyright © 2026 Xpro . All Rights Reserved Term of use SEWAIN
 </div>
</footer>

</body>
</html>