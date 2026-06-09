@php
    $fotoProfil = ($user && $user->foto_profil)
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');

    $status     = $trx->status;
    $ownerName  = $trx->barang && $trx->barang->user ? $trx->barang->user->name : '-';
    $foto       = ($trx->barang && $trx->barang->foto_barang)
        ? asset('storage/' . $trx->barang->foto_barang)
        : asset('assets/img/default-avatar.svg');

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
    $badgeBg    = $badgeBgMap[$status]    ?? 'rgba(67,140,250,0.35)';
    $badgeLabel = $statusLabelMap[$status] ?? ucfirst($status);

    // Hitung durasi sewa
    $durasi = 0;
    if ($trx->tanggal_sewa && $trx->tanggal_kembali_rencana) {
        $durasi = $trx->tanggal_sewa->diffInDays($trx->tanggal_kembali_rencana) ?: 1;
    }
    $hargaPerHari = $trx->barang->harga_sewa ?? 0;
    $subtotal     = $hargaPerHari * $durasi;
@endphp

<x-profile-layout active="rentals" pageTitle="Detail Sewa">

    <div class="dash-content-card" style="position:relative;">
        <div class="profile-avatar" style="position:absolute; top:24px; right:32px; z-index:2;">
            <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
        </div>

        <h2 class="dash-section-title">My Rentals</h2>
        <p class="dash-section-sub">Detail transaksi penyewaan kamu.</p>

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

        <div class="rd-form-grid">
            <div class="rd-field"><label>ID Transaksi</label><div class="rd-value">{{ $trx->formattedId() }}</div></div>
            <div class="rd-field"><label>Owner</label><div class="rd-value">{{ $ownerName }}</div></div>
            <div class="rd-field"><label>User</label><div class="rd-value">{{ $user->name }}</div></div>
            <div class="rd-field"><label>Denda</label><div class="rd-value">-</div></div>
            <div class="rd-field"><label>Date</label><div class="rd-value">{{ optional($trx->tanggal_sewa)->format('d F Y, H.i') ?? '-' }}</div></div>
            <div class="rd-field"><label>Status</label><div class="rd-value">{{ $badgeLabel }}</div></div>
        </div>

        <div id="reviews-section">
            <div class="reviews-header">
                <h3>Receipt</h3>
            </div>

            <div class="receipt-item">
                <div class="receipt-product">
                    <div class="receipt-product-header">
                        <div class="item-badge">1</div>
                        <div class="rec-img">
                            <img src="{{ $foto }}" onerror="this.style.display='none'">
                        </div>
                        <div class="rec-info">
                            <div class="rec-product-name">{{ $trx->barang->nama_barang ?? 'Barang dihapus' }}</div>
                            <div class="rec-price">Rp {{ number_format($hargaPerHari, 0, ',', '.') }}/hari</div>
                        </div>
                        <span class="paid-badge">PAID</span>
                    </div>

                    <div class="rec-dates">
                        <div class="rec-date-item">
                            <div class="rec-date-label">Tanggal Mulai Penyewaan</div>
                            <div class="rec-date-val">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                                </svg>
                                <span class="rec-date-val">{{ optional($trx->tanggal_sewa)->format('d F Y') ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="rec-date-item">
                            <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                            <div class="rec-date-val">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                                </svg>
                                <span class="rec-date-val">{{ optional($trx->tanggal_kembali_rencana)->format('d F Y') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rec-rows">
                        <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $durasi }} Hari</span></div>
                        <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                        <div class="rec-row"><span class="lbl">Shipping</span><span class="val">Rp 0</span></div>
                        <div class="rec-row total-row"><span class="lbl">Total</span><span class="val">Rp {{ number_format($trx->total_harga ?? $subtotal, 0, ',', '.') }}</span></div>
                        <div class="rec-row denda"><span class="lbl">#Catatan Denda</span><span class="val">Rp 15.000/jam</span></div>
                    </div>

                    @if($status === 'aktif')
                    <div style="margin-top: 20px; text-align: right;">
                        <a href="{{ route('profile.rentals.pengembalian', $trx->id) }}" class="btn-ajukan-return" style="text-decoration:none;">
                            AJUKAN PENGEMBALIAN
                        </a>
                    </div>
                    @elseif($status === 'upcoming')
                    <div style="margin-top: 20px; text-align: right;">
                        <form action="{{ route('profile.rentals.cancel', $trx->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan penyewaan ini? Saldo kamu akan dikembalikan.')">
                            @csrf
                            <button type="submit" class="btn-ajukan-return" style="background-color: #9F5556; color: white; border: none; cursor: pointer;">
                                BATALKAN PENYEWAAN
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(in_array($status, ['tunggu verifikasi pengembalian', 'selesai']))
            <div class="confirmed-box" style="margin-top:24px;">
                <div class="check">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <h3>{{ $status === 'selesai' ? 'PENGEMBALIAN SELESAI!' : 'PENGEMBALIAN DIAJUKAN!' }}</h3>
                <p>Status pengembalian kamu saat ini:<br>
                    <strong>{{ $status === 'selesai' ? 'PENGEMBALIAN DISETUJUI ✓ (Completed Rent)' : 'MENUNGGU VERIFIKASI OWNER' }}</strong>
                </p>
            </div>
        @endif
    </div>

</x-profile-layout>
