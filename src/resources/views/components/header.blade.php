<nav class="site-nav">
  <button class="hamburger-btn" aria-label="Toggle menu">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"></line>
      <line x1="3" y1="6" x2="21" y2="6"></line>
      <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
  </button>
 <a href="{{ route('home') }}" class="site-logo">SEWA<span>IN</span></a>
 <ul class="site-nav-links">
   <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
   <li><a href="{{ route('rentals') ?? '#' }}" class="{{ request()->routeIs('rentals') ? 'active' : '' }}">Rentals</a></li>
   <li><a href="{{ route('katalog') ?? '#' }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">My Katalog</a></li>
   @auth
     @if(auth()->user()->role === 'admin')
       <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a></li>
     @endif
   @endauth
 </ul>
 <div class="site-nav-right">
   @auth
     <div style="position: relative; display: inline-flex; align-items: center;" onmouseover="this.querySelector('.dropdown-menu').style.display='block'" onmouseout="this.querySelector('.dropdown-menu').style.display='none'">
       <a href="{{ Route::has('profile') ? route('profile') : '#' }}" class="icon-link" aria-label="Account">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
             d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
         </svg>
       </a>
       <div class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background-color: #fff; min-width: 120px; box-shadow: 0px 8px 16px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; z-index: 100;">
         <form action="{{ route('logout') ?? '/logout' }}" method="POST" style="margin: 0;">
           @csrf
           <button type="submit" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: #333; padding: 12px 16px; font-size: 14px; font-family: inherit;">Logout</button>
         </form>
       </div>
     </div>
     <a href="#" class="icon-link" aria-label="Notifications">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
           d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
       </svg>
       <span class="badge">3</span>
     </a>
     <a href="{{ Route::has('cart') ? route('cart') : '#' }}" class="icon-link" aria-label="Cart">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
           d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
       </svg>
       @php
         $cartCount = \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah');
       @endphp
       <span class="badge" id="cartBadge">{{ $cartCount }}</span>
     </a>
   @else
     <a href="{{ route('login') }}" class="nav-signin">Sign in</a>
     <a href="{{ route('register') }}" class="nav-signup">Sign Up</a>
   @endauth
 </div>
</nav>
