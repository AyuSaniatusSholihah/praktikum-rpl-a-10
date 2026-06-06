@php
    $fotoProfil = $user->foto_profil
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');
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
    @if ($transaksi->isEmpty())
        <p style="color:#8da4be; font-size:13px;">Belum ada transaksi. Riwayat pembayaran sewa Anda akan muncul di sini.</p>
    @else
        <div class="transaksi-grid">
            @foreach ($transaksi as $t)
                @php
                    $foto = $t->barang && $t->barang->foto_barang ? asset('storage/' . $t->barang->foto_barang) : asset('assets/img/default-avatar.svg');
                @endphp
                <a href="{{ route('profile.rentals.produk', $t->id) }}" class="rent-card column" style="text-decoration:none;">
                    <img class="rent-img" src="{{ $foto }}" alt="{{ $t->barang->nama_barang ?? 'Barang' }}">
                    <div class="rent-info">
                        <span class="rent-name">{{ $t->barang->nama_barang ?? 'Barang dihapus' }}</span>
                        <span class="rent-price">Rp {{ number_format($t->total_harga ?? 0, 0, ',', '.') }}</span>
                        <span class="rent-dates">
                            Tanggal Sewa: {{ optional($t->tanggal_sewa)->format('d/m/Y') ?? '-' }}
                            @if ($t->pembayaran)
                                <br>Metode: {{ ucfirst($t->pembayaran->metode) }}
                            @endif
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</x-profile-layout>
