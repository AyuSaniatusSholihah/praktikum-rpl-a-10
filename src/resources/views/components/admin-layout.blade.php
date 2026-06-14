<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Dashboard - SEWAIN Admin' }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Abril+Fatface&family=Abhaya+Libre:wght@400;700&family=Abyssinica+SIL&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;700;800&family=Noto+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/profiledashboard.css') }}">
  {{ $styles ?? '' }}
</head>
<body>

@include('components.admin-header')

<div class="admin-panel {{ isset($scrollable) ? 'panel-scrollable' : '' }}">
<div class="admin-layout">
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
      <!-- DASHBOARD -->
      <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M24.326 10.8738C24.3254 10.8732 24.3248 10.8727 24.3242 10.8721L14.1262 0.674438C13.6915 0.239563 13.1136 0 12.4989 0C11.8841 0 11.3062 0.239372 10.8713 0.674248L0.67866 10.8667C0.675227 10.8702 0.671794 10.8738 0.668361 10.8772C-0.224279 11.775 -0.222753 13.2317 0.672747 14.1272C1.08187 14.5365 1.62223 14.7736 2.19996 14.7984C2.22342 14.8006 2.24707 14.8018 2.27091 14.8018H2.67737V22.3066C2.67737 23.7917 3.88568 25 5.37112 25H9.36091C9.76527 25 10.0933 24.6721 10.0933 24.2676V18.3838C10.0933 17.7061 10.6446 17.1549 11.3222 17.1549H13.6755C14.3532 17.1549 14.9044 17.7061 14.9044 18.3838V24.2676C14.9044 24.6721 15.2323 25 15.6368 25H19.6266C21.1121 25 22.3204 23.7917 22.3204 22.3066V14.8018H22.6973C23.3118 14.8018 23.8898 14.5624 24.3248 14.1275C25.2213 13.2305 25.2217 11.7714 24.326 10.8738Z" fill="currentColor"/>
        </svg>
        Dashboard
      </a></li>

      <!-- FINANCIAL WALLET -->
      <li><a href="{{ route('admin.financial-wallet') }}" class="{{ request()->routeIs('admin.financial-wallet') ? 'active' : '' }}">
        <svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.9608 3.32089V2.96522C22.9608 1.33022 21.6306 0 19.9956 0H2.96522C1.33016 5.07813e-05 0 1.33022 0 2.96522V3.32089H22.9608Z" fill="currentColor"/>
          <path d="M13.5651 12.8592C13.5651 11.3211 14.0598 9.85913 14.9731 8.6543H0V12.7905C0 14.4255 1.33016 15.7557 2.96522 15.7557H14.1911C13.7813 14.8581 13.5651 13.8754 13.5651 12.8592ZM11.4804 11.9605H8.92125V10.437H11.4804V11.9605ZM3.41545 10.437H7.39781V11.9605H3.41545V10.437Z" fill="currentColor"/>
          <path d="M16.5547 7.13076C17.7165 6.31791 19.0967 5.87997 20.5443 5.87997C21.3822 5.87997 22.1973 6.02709 22.9608 6.30826V4.84424H0V7.13076H16.5547Z" fill="currentColor"/>
          <path d="M26.0013 12.859C26.0013 9.8459 23.5587 7.40332 20.5456 7.40332C17.5325 7.40332 15.0898 9.8459 15.0898 12.859C15.0898 15.8721 17.5324 18.3147 20.5456 18.3147C23.5587 18.3147 26.0013 15.8721 26.0013 12.859ZM21.281 15.7736V16.3936H20.5193V16.3936V16.3936H19.7576V15.7782C19.297 15.6222 18.9202 15.3478 18.5523 15.0788L19.4516 13.8491C19.946 14.2107 20.1989 14.3844 20.5456 14.3844C20.7416 14.3844 20.9003 14.2911 20.9598 14.141C21.0318 13.9592 20.93 13.7917 20.6874 13.6929C20.6874 13.6929 19.5986 13.3298 19.0952 12.8166C18.6729 12.386 18.5385 11.7792 18.673 11.202C18.8083 10.6208 19.2008 10.1663 19.7576 9.93939V9.32433H21.281V9.9139C21.6679 10.0213 21.9954 10.1801 22.1837 10.2824L21.4568 11.6212C20.9749 11.3596 20.5316 11.2811 20.3591 11.3401C20.1916 11.3973 20.1662 11.5065 20.1566 11.5476C20.143 11.6059 20.1358 11.6953 20.2289 11.799C20.3185 11.8989 21.2618 12.282 21.2618 12.282C22.2796 12.6963 22.7585 13.7368 22.376 14.7022C22.1773 15.2039 21.7774 15.5839 21.281 15.7736Z" fill="currentColor"/>
          </svg>
        Financial Wallet
      </a></li>

      <!-- USERS -->
      <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') || request()->routeIs('admin.users.detail') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="none">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
        </svg>
        Users
      </a></li>

      <!-- ITEMS -->
      <li><a href="{{ route('admin.items') }}" class="{{ request()->routeIs('admin.items') || request()->routeIs('admin.items.detail') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z"/>
          <path fill-rule="evenodd" d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z" clip-rule="evenodd"/>
        </svg>
        Items
      </a></li>

      <!-- TRANSACTIONS -->
      <li><a href="{{ route('admin.transactions') }}" class="{{ request()->routeIs('admin.transactions') || request()->routeIs('admin.transactions.detail') ? 'active' : '' }}">
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.20703 22.9168C5.20769 23.4692 5.42739 23.9987 5.81795 24.3892C6.20851 24.7798 6.73803 24.9995 7.29036 25.0002H17.707C18.2594 24.9995 18.7889 24.7798 19.1794 24.3892C19.57 23.9987 19.7897 23.4692 19.7904 22.9168V22.0054H5.20703V22.9168Z" fill="currentColor"/>
          <path d="M19.7904 2.08333C19.7897 1.531 19.57 1.00148 19.1794 0.610917C18.7889 0.220358 18.2594 0.00065473 17.707 0L7.29036 0C6.73803 0.00065473 6.20851 0.220358 5.81795 0.610917C5.42739 1.00148 5.20769 1.531 5.20703 2.08333V3.125H19.7904V2.08333Z" fill="currentColor"/>
          <path d="M24.7111 6.70052L21.5861 3.44531L20.0832 4.88802L21.3906 6.25H19.793V8.33333H21.503L20.1139 9.66459L21.5553 11.1688L24.6803 8.17396C24.7792 8.07926 24.8583 7.96602 24.9134 7.8407C24.9684 7.71538 24.9982 7.58045 25.001 7.44361C25.0039 7.30677 24.9798 7.17071 24.93 7.04321C24.8802 6.91571 24.8058 6.79926 24.7111 6.70052Z" fill="currentColor"/>
          <path d="M16.6654 6.24984H19.7904V4.1665H5.20703V16.6665H8.33203V18.7498H5.20703V20.8332H19.7904V8.33317H16.6654V6.24984ZM15.6237 10.4165H11.9779C11.8397 10.4165 11.7073 10.4714 11.6096 10.5691C11.5119 10.6667 11.457 10.7992 11.457 10.9373C11.457 11.0755 11.5119 11.2079 11.6096 11.3056C11.7073 11.4033 11.8397 11.4582 11.9779 11.4582H13.0195C13.6653 11.4575 14.2884 11.6969 14.7676 12.1297C15.2469 12.5626 15.5482 13.1581 15.6131 13.8006C15.678 14.4432 15.5019 15.0869 15.1188 15.6069C14.7358 16.1268 14.1733 16.4859 13.5404 16.6144V17.7082H11.457V16.6665H9.3737V14.5832H13.0195C13.1577 14.5832 13.2901 14.5283 13.3878 14.4306C13.4855 14.3329 13.5404 14.2005 13.5404 14.0623C13.5404 13.9242 13.4855 13.7917 13.3878 13.6941C13.2901 13.5964 13.1577 13.5415 13.0195 13.5415H11.9779C11.3321 13.5422 10.709 13.3028 10.2298 12.87C9.7505 12.4371 9.44917 11.8416 9.38426 11.1991C9.31936 10.5565 9.49552 9.91278 9.87855 9.39282C10.2616 8.87286 10.8241 8.51377 11.457 8.38525V7.2915H13.5404V8.33317H15.6237V10.4165Z" fill="currentColor"/>
          <path d="M3.49828 16.6665L4.88734 15.3352L3.44593 13.8311L0.320931 16.8258C0.222115 16.9205 0.142929 17.0338 0.0879011 17.1591C0.0328728 17.2844 0.00308028 17.4194 0.000226477 17.5562C-0.00262733 17.693 0.0215135 17.8291 0.0712692 17.9566C0.121025 18.0841 0.19542 18.2005 0.290202 18.2993L3.4152 21.5545L4.91807 20.1118L3.61064 18.7498H5.2083V16.6665H3.49828Z" fill="currentColor"/>
        </svg>
        Transactions
      </a></li>

      <!-- SETTING -->
      <li><a href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd"/>
        </svg>
        Setting
      </a></li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content {{ isset($scrollable) ? 'main-scrollable' : '' }}" {{ isset($pageId) ? 'id=' . $pageId : '' }}>
    @if(isset($headerTitle))
      <div class="page-title">{{ $headerTitle }}</div>
    @endif
    {{ $slot }}
  </main>

</div>
</div>

<!-- FOOTER -->
@include('components.footer')

<script>
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const sidebar = document.getElementById('sidebar');
  mobileMenuBtn.addEventListener('click', () => sidebar.classList.toggle('mobile-open'));
  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
      sidebar.classList.remove('mobile-open');
    }
  });
</script>
@include('components.admin-confirm')
{{ $scripts ?? '' }}
</body>
</html>
