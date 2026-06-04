@php
    $fotoProfil = $user->foto_profil
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');

    // Data contoh — siap diganti query Pembayaran/TransaksiPenyewaan milik user.
    $transaksi = [
        ['img' => 'ip 18b air.webp',     'name' => 'Iphone 17 Air (Hijau)',                       'price' => 'Rp 300.000', 'sewa' => '17/04/2026 s.d 18/04/2026'],
        ['img' => 'lampu camp.webp',     'name' => '1 Sunrei Lampu Camping Wraith (Hike and Ride)', 'price' => 'Rp 25.000',  'sewa' => '17/04/2026 s.d 18/04/2026'],
        ['img' => 'sound system.jpg',    'name' => 'Yamaha Pro Audio Paket 12P Paket Sound System', 'price' => 'Rp 750.000', 'sewa' => '18/04/2026 s.d 22/04/2026'],
    ];
@endphp

<x-profile-layout active="wallet" pageTitle="My Wallet">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Wallet</h2>
        <p class="section-subtitle">Here is your quick overview</p>
    </div>

    <div class="content-grid">
        <form class="profile-form">
            <div class="form-group">
                <label>Name Account User:</label>
                <input type="text" value="{{ $user->name }}" readonly>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" value="{{ $user->email }}" readonly>
            </div>

            <div class="form-group">
                <label>Informasi Rekening:</label>
                <textarea rows="4" readonly>Nama Rekening: BSI Syariah&#10;No Rekening: 763098218847&#10;A/n: {{ $user->name }}</textarea>
            </div>
        </form>

        <div class="stats-panel">
            <div class="profile-pic-large">
                <img src="{{ $fotoProfil }}" alt="Profile" width="80" height="80">
            </div>

            <div class="saldo-card">
                <div class="saldo-header">
                    <span class="badge">+0.3%</span>
                    <span class="saldo-title">Saldo</span>
                </div>
                <h3>Rp {{ number_format($user->saldo ?? 0, 2, ',', '.') }}</h3>
                <div class="currency-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
            </div>
        </div>
    </div>

    <h3 class="section-divider-title">My Wallet &mdash; Riwayat Transaksi</h3>
    <div class="transaksi-grid">
        @foreach ($transaksi as $item)
            <div class="rent-card column">
                <img class="rent-img" src="{{ asset('assets/img/' . $item['img']) }}" alt="{{ $item['name'] }}">
                <div class="rent-info">
                    <span class="rent-name">{{ $item['name'] }}</span>
                    <span class="rent-price">{{ $item['price'] }}</span>
                    <span class="rent-dates">Tanggal Sewa: {{ $item['sewa'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

</x-profile-layout>
