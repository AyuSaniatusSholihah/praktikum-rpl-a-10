<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>{{ $title ?? 'SEWAIN — Sewa Barang Mudah & Terpercaya' }}</title>
 <link rel="preconnect" href="https://fonts.googleapis.com" />
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
 <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&family=Jomolhari&family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Poppins:wght@300;400;500;600;700&family=Vidaloka&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css2?family=Rochester&display=swap" rel="stylesheet" />
 <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}" />
 {{ $styles ?? '' }}
</head>
<body>

<x-header />

<main>
    {{ $slot }}
</main>

<x-footer />

@if(request()->routeIs('home'))
<div class="floating-actions">
 @auth
<button class="floating-btn" onclick="openReviewModal()" style="background:#4D6674; border-radius:50%;" title="Beri Ulasan SEWAIN">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
</button>
 @endauth
 <button class="floating-btn" onclick="location.href='{{ Route::has('cart') ? route('cart') : '#' }}'" title="Cart">
   <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
 </button>
 <button class="floating-btn light" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Top">↑</button>
</div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger-btn');
    const navLinks = document.querySelector('.site-nav-links');
    if (hamburger && navLinks) {
      hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-open');
      });
    }
  });
</script>

{{ $scripts ?? '' }}

@include('components.sewain-confirm')

</body>
</html>
