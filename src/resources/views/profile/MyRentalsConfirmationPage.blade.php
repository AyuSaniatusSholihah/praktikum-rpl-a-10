@php
    $fotoProfil = ($user && $user->foto_profil)
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');

    $status = $trx->status;
    $foto   = ($trx->barang && $trx->barang->foto_barang)
        ? asset('storage/' . $trx->barang->foto_barang)
        : asset('assets/img/default-avatar.svg');
    $ownerName = $trx->barang && $trx->barang->user ? $trx->barang->user->name : '-';

    $badgeBgMap = [
        'upcoming'                        => 'rgba(235, 245, 48, 0.35)',
        'aktif'                           => 'rgba(67, 140, 250, 0.35)',
        'tunggu verifikasi pengembalian'  => 'rgba(250, 164, 67, 0.35)',
        'selesai'                         => 'rgba(52, 237, 74, 0.35)',
        'dibatalkan'                      => 'rgba(248, 50, 32, 0.35)',
    ];
    $statusLabelMap = [
        'upcoming'                        => 'Upcoming Rent',
        'aktif'                           => 'Active Rent',
        'tunggu verifikasi pengembalian'  => 'Return Rent',
        'selesai'                         => 'Completed Rent',
        'dibatalkan'                      => 'Canceled Rent',
    ];
    $badgeBg    = $badgeBgMap[$status]    ?? 'rgba(52,237,74,0.35)';
    $badgeLabel = $statusLabelMap[$status] ?? ucfirst($status);

    $returnStatusText = match($status) {
        'selesai'                        => 'PENGEMBALIAN DISETUJUI ✓',
        'tunggu verifikasi pengembalian' => 'MENUNGGU VERIFIKASI OWNER',
        default                          => strtoupper($status),
    };
@endphp

<x-profile-layout active="rentals" pageTitle="Status Pengembalian">

    <div class="dash-content-card" style="position:relative;">
        <div class="profile-avatar" style="position:absolute; top:24px; right:32px; z-index:2;">
            <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
        </div>

        <h2 class="dash-section-title">My Rentals</h2>
        <p class="dash-section-sub">Status pengembalian barang kamu.</p>

        <div class="rental-detail-header">
            <div class="rd-thumb" style="position:relative;">
                <img src="{{ $foto }}" alt="{{ $trx->barang->nama_barang ?? 'Barang' }}" onerror="this.style.display='none'"/>
                <span id="statusBadge" style="
                    position:absolute; top:6px; left:6px;
                    background:{{ $badgeBg }};
                    color:#fff; font-family:'Inter',sans-serif;
                    font-size:10px; padding:3px 8px;
                    border-radius:4px; z-index:3; line-height:1.4;
                ">{{ $badgeLabel }}</span>
            </div>
            <h3>{{ $trx->barang->nama_barang ?? 'Barang dihapus' }}</h3>
        </div>

        <div class="rental-detail-body">
        <div class="rd-form-grid">
            <div class="rd-field"><label>ID Transaksi</label><div class="rd-value">{{ $trx->formattedId() }}</div></div>
            <div class="rd-field"><label>Owner</label><div class="rd-value">{{ $ownerName }}</div></div>
            <div class="rd-field"><label>Tanggal Mulai</label><div class="rd-value">{{ optional($trx->tanggal_sewa)->format('d M Y, H.i') ?? '-' }} WIB</div></div>
            <div class="rd-field"><label>Tanggal Selesai</label><div class="rd-value">{{ optional($trx->tanggal_kembali_rencana)->format('d M Y, H.i') ?? '-' }} WIB</div></div>
            <div class="rd-field"><label>Metode Pembayaran</label><div class="rd-value">Saldo SEWAIN Wallet</div></div>
            <div class="rd-field"><label>Lokasi Pengambilan</label><div class="rd-value">{{ $trx->barang->alamat ?? '-' }}</div></div>
        </div>

        <div class="confirmed-box">
            <div class="check">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h3>RETURN CONFIRMED!</h3>
            <p>
                Terima Kasih telah menggunakan Website SEWAIN sebagai platform penyewaan Anda!
            </p>
            <p>
                Status Return Rent Anda saat ini:<br>
                <strong id="returnStatus">{{ $returnStatusText }}</strong>
            </p>
            <a href="{{ route('profile') }}" class="btn-back">Back to SEWAIN Profile</a>
        </div>
        </div>
    </div>

</x-profile-layout>
