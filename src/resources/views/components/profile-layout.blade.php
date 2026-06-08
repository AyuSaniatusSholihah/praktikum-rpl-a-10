@props([
    'active'    => 'profile',
    'pageTitle' => 'Profile',
    'styles'    => null,
])

@php
    $authUser   = auth()->user();
    $fotoProfil = ($authUser && $authUser->foto_profil)
        ? asset('storage/' . $authUser->foto_profil)
        : asset('assets/img/default-avatar.svg');
    $roleLabel = ($authUser && $authUser->role === 'admin') ? 'Admin Account' : 'Free Account';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $pageTitle }} — SEWAIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Pacifico&family=Poppins:wght@300;400;500;600;700;800&family=Vidaloka&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700;800&family=Jomolhari&family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Vidaloka&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Lato:wght@400;700&family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Amethysta&family=Abhaya+Libre:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/profiledashboard.css') }}">
    {{ $styles ?? '' }}
    <style>
      .dash-profile-mini .avatar image {
          width: 100%;
          height: 100%;
          object-fit: cover;
      }
    </style>
</head>
<body>

<x-header />

<section class="profile-page dash-page">
    <div class="container" style="max-width:1280px; margin:0 auto;">
        <div class="dash-panel">
            <!-- SIDEBAR -->
            <aside class="dash-sidebar">
                <div class="dash-profile-mini">
                    <div class="avatar" style="overflow: hidden; border-radius: 4px;">
                        <img src="{{ $fotoProfil }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile" onerror="this.style.display='none'"/>
                    </div>
                    <div class="name">{{ $authUser->name ?? 'Guest' }}</div>
                </div>
                <nav class="dash-nav">
                    <a href="{{ route('profile') }}" class="{{ $active === 'profile' ? 'active' : '' }}">
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.29102 11.4697C6.55107 11.4697 7.56132 12.6105 7.56152 14.0303V17.4395C7.56152 18.8494 6.5512 20 5.29102 20H2.27051C1.01926 20 0 18.8495 0 17.4395V14.0303C0.000204005 12.6105 1.01938 11.4697 2.27051 11.4697H5.29102ZM15.6045 11.4697C16.8556 11.4697 17.8748 12.6105 17.875 14.0303V17.4395C17.875 18.8495 16.8557 20 15.6045 20H12.584C11.3238 19.9999 10.3145 18.8494 10.3145 17.4395V14.0303C10.3147 12.6105 11.324 11.4698 12.584 11.4697H15.6045ZM5.29102 0C6.55106 9.42045e-06 7.56131 1.14976 7.56152 2.56055V5.96973C7.56152 7.38972 6.5512 8.53026 5.29102 8.53027H2.27051C1.01926 8.53027 0 7.38973 0 5.96973V2.56055C0.000218157 1.14975 1.01939 0 2.27051 0H5.29102Z" fill="white"/>
                            <path d="M15.6045 0C16.8556 0 17.8748 1.14976 17.875 2.56055V5.96973C17.875 7.38972 16.8557 8.53026 15.6045 8.53027H12.584C11.3238 8.53017 10.3145 7.38972 10.3145 5.96973V2.56055C10.3147 1.14975 11.324 0 12.584 0H15.6045Z" fill="#111111" fill-opacity="0.16"/>
                        </svg>
                        Profile
                    </a>
                    <a href="{{ route('profile.rentals') }}" class="{{ $active === 'rentals' ? 'active' : '' }}">
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 16H17V8H11V16H13V10H15V16ZM1 16V1C1 0.44772 1.44772 0 2 0H16C16.5523 0 17 0.44772 17 1V6H19V16H20V18H0V16H1ZM5 8V10H7V8H5ZM5 12V14H7V12H5ZM5 4V6H7V4H5Z" fill="white"/>
                        </svg>
                        My Rentals
                    </a>
                    <a href="{{ route('profile.owner') }}" class="{{ $active === 'owner' ? 'active' : '' }}">
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 16H17V8H11V16H13V10H15V16ZM1 16V1C1 0.44772 1.44772 0 2 0H16C16.5523 0 17 0.44772 17 1V6H19V16H20V18H0V16H1ZM5 8V10H7V8H5ZM5 12V14H7V12H5ZM5 4V6H7V4H5Z" fill="white"/>
                        </svg>
                        Rentals Owner
                    </a>
                    <a href="{{ route('profile.wallet') }}" class="{{ $active === 'wallet' ? 'active' : '' }}">
                        <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 7.99997V9.99997C22 13.3137 17.0751 16 11 16C5.03336 16 0.17626 13.4088 0.00469005 10.1769L0 9.99997V7.99997C0 11.3137 4.92487 14 11 14C17.0751 14 22 11.3137 22 7.99997ZM11 0C17.0751 0 22 2.68629 22 5.99997C22 9.31367 17.0751 12 11 12C4.92487 12 0 9.31367 0 5.99997C0 2.68629 4.92487 0 11 0Z" fill="white"/>
                        </svg>
                        My Wallet
                    </a>
                    <a href="#">
                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7168 0.500183C11.4731 0.500183 12.158 0.92025 12.5362 1.54022C12.7201 1.84012 12.8431 2.20994 12.8125 2.59979C12.7921 2.89979 12.8834 3.20065 13.0469 3.48065C13.5682 4.33053 14.7238 4.65008 15.6231 4.1701C16.6347 3.59045 17.9116 3.94022 18.4942 4.92987L19.1787 6.11053C19.7714 7.10052 19.4448 8.37064 18.4229 8.94061C17.5543 9.45065 17.2474 10.5807 17.7686 11.4406C17.9321 11.7105 18.1163 11.9403 18.4024 12.0803C18.7601 12.2703 19.0363 12.5703 19.2305 12.8703C19.6084 13.4902 19.5778 14.2502 19.21 14.9201L18.4942 16.1203C18.116 16.7602 17.4111 17.1603 16.6856 17.1603C16.3281 17.1603 15.9295 17.0604 15.6026 16.8605C15.3369 16.6906 15.0301 16.6301 14.7032 16.6301C13.6914 16.6301 12.8432 17.4604 12.8125 18.4504C12.8124 19.6001 11.8723 20.4999 10.6973 20.5002H9.30668C8.12141 20.5 7.18178 19.6002 7.18168 18.4504C7.16124 17.4604 6.31256 16.6301 5.30082 16.6301C4.9636 16.6301 4.65688 16.6905 4.4014 16.8605C4.07446 17.0604 3.66574 17.1603 3.3184 17.1603C2.5826 17.1603 1.87719 16.7603 1.49906 16.1203L0.793983 14.9201C0.41594 14.2702 0.395463 13.4902 0.773475 12.8703C0.936944 12.5704 1.24351 12.2703 1.59086 12.0803C1.87696 11.9403 2.06168 11.7106 2.23539 11.4406C2.74637 10.5806 2.43901 9.45061 1.57035 8.94061C0.558793 8.37063 0.23221 7.10046 0.814491 6.11053L1.49906 4.92987C2.0918 3.94006 3.35903 3.5903 4.3809 4.1701C5.26989 4.65005 6.42504 4.33043 6.94633 3.48065C7.10984 3.20065 7.20212 2.89979 7.18168 2.59979C7.16133 2.20993 7.2737 1.84013 7.46781 1.54022C7.84595 0.9203 8.53043 0.520182 9.2764 0.500183H10.7168ZM10.0118 7.67987C8.40753 7.68006 7.10954 8.94017 7.10941 10.5099C7.10941 12.0798 8.40745 13.3301 10.0118 13.3303C11.6162 13.3303 12.8838 12.0799 12.8838 10.5099C12.8837 8.94006 11.6161 7.67987 10.0118 7.67987Z" fill="white"/>
                        </svg>
                        Settings
                    </a>
                </nav>
                <div class="dash-logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.91016 0C9.97896 0 11.667 1.65853 11.667 3.7002V7.69141H6.5791C6.2148 7.69159 5.92693 7.97495 5.92676 8.33301C5.92676 8.68289 6.21469 8.97442 6.5791 8.97461H11.667V12.958C11.667 14.9997 9.97931 16.667 7.89355 16.667H3.76465C1.68742 16.667 7.12021e-05 15.0084 0 12.9668V3.70801C0.00017951 1.65816 1.69627 0 3.77344 0H7.91016ZM13.7832 5.45898C14.0331 5.20073 14.4414 5.20041 14.6914 5.4502L17.125 7.875C17.25 8 17.3164 8.15898 17.3164 8.33398C17.3163 8.50047 17.2499 8.66665 17.125 8.7832L14.6914 11.209C14.5665 11.3336 14.4002 11.4003 14.2422 11.4004C14.0756 11.4004 13.9082 11.3339 13.7832 11.209C13.5332 10.959 13.5332 10.5498 13.7832 10.2998L15.1172 8.97559H11.667V7.69141H15.1172L13.7832 6.36719C13.5333 6.11732 13.5336 5.70902 13.7832 5.45898Z" fill="white"/>
                            </svg>
                            Log Out
                        </a>
                    </form>
                </div>
            </aside>

            <!-- CONTENT -->
            <div class="dash-content">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>

<x-footer />

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hamburger = document.querySelector('.hamburger-btn');
        const navLinks  = document.querySelector('.site-nav-links');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', () => navLinks.classList.toggle('nav-open'));
        }
    });
</script>

</body>
</html>
