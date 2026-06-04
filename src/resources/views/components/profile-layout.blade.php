@props([
    'active' => 'profile',
    'pageTitle' => 'Profile',
    'styles' => null,
])

@php
    $authUser = auth()->user();
    $fotoProfil = ($authUser && $authUser->foto_profil)
        ? asset('storage/' . $authUser->foto_profil)
        : asset('assets/img/default-avatar.svg');
    $roleLabel = ($authUser && $authUser->role === 'admin') ? 'Admin Account' : 'Free Account';

    $menu = [
        'profile'  => ['label' => 'Profile',       'icon' => 'fa-border-all', 'route' => 'profile'],
        'rentals'  => ['label' => 'My Rentals',     'icon' => 'fa-retweet',    'route' => 'profile.rentals'],
        'owner'    => ['label' => 'Rentals Owner',  'icon' => 'fa-store',      'route' => 'profile.owner'],
        'wallet'   => ['label' => 'My Wallet',      'icon' => 'fa-wallet',     'route' => 'profile.wallet'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEWAIN - {{ $pageTitle }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    {{ $styles }}
</head>
<body>

    <header class="navbar">
        <div class="logo">SEWA<span>IN</span></div>
        <nav class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('rentals') }}">Rentals</a>
            <a href="{{ route('katalog') }}">My Katalogs</a>
        </nav>
        <div class="nav-icons">
            <a href="{{ route('profile') }}"><i class="fa-solid fa-user"></i></a>
            <i class="fa-regular fa-bell"></i>
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </header>

    <main class="dashboard-container">

        <aside class="sidebar">
            <div class="profile-selector">
                <div class="avatar-mini" style="background-image: url('{{ $fotoProfil }}'); background-size: cover; background-position: center;"></div>
                <div>
                    <h4>{{ $authUser->name ?? 'Guest' }}</h4>
                    <span class="dropdown-arrow">▼</span>
                </div>
            </div>

            <ul class="sidebar-menu">
                @foreach ($menu as $key => $item)
                    <li class="{{ $active === $key ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}"><i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
                    </li>
                @endforeach
                <hr class="sidebar-divider">
                <li class="{{ $active === 'settings' ? 'active' : '' }}"><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
            </ul>

            <div class="sidebar-footer">
                <img src="{{ $fotoProfil }}" alt="Avatar" class="footer-avatar" width="40" height="40">
                <div>
                    <h5>{{ $authUser->name ?? 'Guest' }}</h5>
                    <p>{{ $roleLabel }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-left:auto;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fa-solid fa-right-from-bracket logout-icon"></i>
                    </button>
                </form>
            </div>
        </aside>

        <section class="main-content">
            {{ $slot }}
        </section>

    </main>

    <footer class="main-footer">
        <div class="footer-left">
            <div class="logo">SEWA<span>IN</span></div>
            <p>We help you find and rent what you need easily</p>
            <div class="social-icons">
                <a href="#"><i class="fa-solid fa-phone"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-solid fa-globe"></i></a>
                <a href="#"><i class="fa-regular fa-envelope"></i></a>
            </div>
        </div>
        <div class="footer-links-container">
            <div class="footer-column">
                <h4>Information</h4>
                <a href="#">About</a>
                <a href="#">Product</a>
                <a href="#">Blog</a>
            </div>
            <div class="footer-column">
                <h4>Company</h4>
                <a href="#">Community</a>
                <a href="#">Career</a>
                <a href="#">Our story</a>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <a href="#">Getting Started</a>
                <a href="#">Pricing</a>
                <a href="#">Resources</a>
            </div>
        </div>
    </footer>

</body>
</html>
