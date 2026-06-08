<nav class="site-nav">
  <button class="hamburger-btn" aria-label="Toggle menu" id="mobileMenuBtn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"></line>
      <line x1="3" y1="6" x2="21" y2="6"></line>
      <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
  </button>
  <a href="{{ route('home') }}" class="site-logo">SEWA<span>IN</span></a>
  <ul class="site-nav-links">
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a></li>
  </ul>
  
  <form action="{{ request()->routeIs('admin.users') ? route('admin.users') : (request()->routeIs('admin.transactions') ? route('admin.transactions') : route('admin.items')) }}" method="GET" class="nav-search" style="margin-left: auto; margin-right: 20px;">
     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
     <input type="search" name="search" value="{{ request('search') }}" placeholder="Search here..." aria-label="Search"/>
  </form>
  
  <div class="site-nav-right">
    <div class="profile-dropdown" style="position: relative; display: inline-block;">
      <a href="#" aria-label="Account" class="icon-link" onclick="const menu = this.nextElementSibling; menu.style.display = menu.style.display === 'none' ? 'block' : 'none'; return false;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
      </a>
      <div class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background: #ffffff; min-width: 140px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); border-radius: 8px; z-index: 1000; padding: 6px 0; border: 1px solid #f0f0f0;">
        <a href="{{ route('profile') }}" style="display: block; padding: 10px 16px; color: #333; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: background 0.2s ease;">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Profile
        </a>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
          @csrf
          <button type="submit" style="width: 100%; text-align: left; padding: 10px 16px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: 13px; color: #dc2626; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Log Out
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>
