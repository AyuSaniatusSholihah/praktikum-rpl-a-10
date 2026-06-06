@php
    $badgeMap = [
        'upcoming'                        => ['UpComing Rent', 'upcoming'],
        'aktif'                           => ['Active Rent', 'active'],
        'tunggu verifikasi pengembalian'  => ['Return Rent', 'returning'],
        'selesai'                         => ['Selesai', 'confirmed'],
        'dibatalkan'                      => ['Dibatalkan', 'returning'],
    ];
@endphp

<x-profile-layout active="owner" pageTitle="Rentals Owner">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals Owner</h2>
        <p class="section-subtitle">Barang Anda yang sedang/pernah disewa orang lain</p>
    </div>

    @if ($aktif->isEmpty())
        <p style="color:#8da4be; font-size:13px;">Belum ada barang Anda yang sedang disewa.</p>
    @else
        <div class="rentals-grid">
            @foreach ($aktif as $t)
                @php
                    $badge = $badgeMap[$t->status] ?? ['Rent', 'active'];
                    $foto = $t->barang && $t->barang->foto_barang ? asset('storage/' . $t->barang->foto_barang) : asset('assets/img/default-avatar.svg');
                @endphp
                <div class="rent-card">
                    <span class="rent-badge {{ $badge[1] }}">{{ $badge[0] }}</span>
                    <img class="rent-img" src="{{ $foto }}" alt="{{ $t->barang->nama_barang ?? 'Barang' }}">
                    <div class="rent-info">
                        <span class="rent-name">{{ $t->barang->nama_barang ?? 'Barang dihapus' }}</span>
                        <span class="rent-price">Rp {{ number_format($t->total_harga ?? 0, 0, ',', '.') }}</span>
                        <span class="rent-dates">
                            Penyewa: {{ $t->user->name ?? '-' }}<br>
                            Tanggal Sewa: {{ optional($t->tanggal_sewa)->format('d/m/Y') ?? '-' }}
                            s.d {{ optional($t->tanggal_kembali_rencana)->format('d/m/Y') ?? '-' }}
                        </span>
                    </div>
                    <a href="{{ route('profile.owner.produk', $t->id) }}" class="rent-action-btn">Detail</a>
                </div>
            @endforeach
        </div>
    @endif

    <h3 class="section-divider-title">My Rentals Owner &mdash; History</h3>
    @if ($history->isEmpty())
        <p style="color:#8da4be; font-size:13px;">Belum ada riwayat penyewaan yang selesai.</p>
    @else
        <div class="history-grid">
            @foreach ($history as $t)
                @php
                    $foto = $t->barang && $t->barang->foto_barang ? asset('storage/' . $t->barang->foto_barang) : asset('assets/img/default-avatar.svg');
                @endphp
                <a href="{{ route('profile.owner.produk', $t->id) }}" class="rent-card" style="text-decoration:none;">
                    <img class="rent-img" src="{{ $foto }}" alt="{{ $t->barang->nama_barang ?? 'Barang' }}">
                    <div class="rent-info">
                        <span class="rent-name">{{ $t->barang->nama_barang ?? 'Barang dihapus' }}</span>
                        <span class="rent-price">Rp {{ number_format($t->total_harga ?? 0, 0, ',', '.') }}</span>
                        <span class="rent-dates">
                            Penyewa: {{ $t->user->name ?? '-' }}<br>
                            Tanggal Sewa: {{ optional($t->tanggal_sewa)->format('d/m/Y') ?? '-' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</x-profile-layout>
