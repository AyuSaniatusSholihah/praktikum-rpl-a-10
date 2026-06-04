@php
    // Data contoh — siap diganti query TransaksiPenyewaan milik user yang login.
    $aktif = [
        [
            'img'   => 'lampu camp.webp',
            'name'  => 'Penyewaan Peralatan Fotografi (Khusus Lampu Studio & Aksesoris)',
            'price' => 'Rp 100.000',
            'sewa'  => '20/04/2026 s.d 23/04/2026 (06.00 WIB)',
            'extra' => 'Return Item: 22/04/2026 (06.00 WIB)',
            'badge' => ['UpComing Rent', 'upcoming'],
        ],
        [
            'img'   => 'sound system.jpg',
            'name'  => 'ALLTREK Tenda Camping 1 Bedroom + 1 Guest Room',
            'price' => 'Rp 750.000',
            'sewa'  => '20/04/2026 s.d 23/04/2026 (06.00 WIB)',
            'extra' => 'Return Item: 06/04/2026 (06.00 WIB)',
            'badge' => ['Active Rent', 'active'],
        ],
    ];

    $history = [
        ['img' => 'ip 18b air.webp',     'name' => 'Iphone 17 Air (Hijau)',  'price' => 'Rp 300.000', 'sewa' => '17/04/2026 s.d 18/04/2026'],
        ['img' => 'fortuner mobil.jpg',  'name' => 'Mobil Fortuner Hitam',   'price' => 'Rp 300.000', 'sewa' => '02/02/2026 s.d 02/02/2026'],
    ];
@endphp

<x-profile-layout active="rentals" pageTitle="My Rentals">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals</h2>
        <p class="section-subtitle">Here is your quick overview</p>
    </div>

    {{-- Penyewaan aktif / berlangsung --}}
    <div class="rentals-grid">
        @foreach ($aktif as $item)
            <div class="rent-card">
                <span class="rent-badge {{ $item['badge'][1] }}">{{ $item['badge'][0] }}</span>
                <img class="rent-img" src="{{ asset('assets/img/' . $item['img']) }}" alt="{{ $item['name'] }}">
                <div class="rent-info">
                    <span class="rent-name">{{ $item['name'] }}</span>
                    <span class="rent-price">{{ $item['price'] }}</span>
                    <span class="rent-dates">Tanggal Sewa: {{ $item['sewa'] }}<br>{{ $item['extra'] }}</span>
                </div>
                <a href="{{ route('profile.rentals.produk') }}" class="rent-action-btn">Return Item</a>
            </div>
        @endforeach
    </div>

    {{-- Riwayat sewa --}}
    <h3 class="section-divider-title">My Rentals &mdash; History</h3>
    <div class="history-grid">
        @foreach ($history as $item)
            <div class="rent-card">
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
