@php
    // Data contoh — siap diganti query barang milik user (owner) yang sedang disewa.
    $aktif = [
        [
            'img'   => 'sound system.jpg',
            'name'  => 'Yamaha Pro Audio Paket 12P Paket Sound System',
            'price' => 'Rp 750.000',
            'sewa'  => '03/04/2026 s.d 20/04/2026 (06.00 WIB)',
            'extra' => 'Return Item: 06/04/2026 (06.00 WIB)',
            'badge' => ['Return Rent', 'returning'],
        ],
        [
            'img'   => 'tenda altrek.webp',
            'name'  => 'ALLTREK Tenda Camping 1 Bedroom + 1 Guest Room',
            'price' => 'Rp 750.000',
            'sewa'  => '12/03/2026 s.d 15/03/2026 (06.00 WIB)',
            'extra' => 'Return Item: 17/03/2026 (06.00 WIB)',
            'badge' => ['Active Rent', 'active'],
        ],
    ];

    $history = [
        ['img' => 'lampu camp.webp', 'name' => '1 Sunrei Lampu Camping Wraith (Hike and Ride)', 'price' => 'Rp 25.000', 'sewa' => '17/04/2026 s.d 18/04/2026', 'extra' => 'Return Item: 18/04/2026 (06.00 WIB)'],
    ];
@endphp

<x-profile-layout active="owner" pageTitle="Rentals Owner">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals Owner</h2>
        <p class="section-subtitle">Here is your quick overview</p>
    </div>

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
                <a href="{{ route('profile.owner.produk') }}" class="rent-action-btn">Detail</a>
            </div>
        @endforeach
    </div>

    <h3 class="section-divider-title">My Rentals Owner &mdash; History</h3>
    <div class="history-grid">
        @foreach ($history as $item)
            <div class="rent-card">
                <img class="rent-img" src="{{ asset('assets/img/' . $item['img']) }}" alt="{{ $item['name'] }}">
                <div class="rent-info">
                    <span class="rent-name">{{ $item['name'] }}</span>
                    <span class="rent-price">{{ $item['price'] }}</span>
                    <span class="rent-dates">Tanggal Sewa: {{ $item['sewa'] }}<br>{{ $item['extra'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

</x-profile-layout>
