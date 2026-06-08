@php
    $fotoProfil = ($user && $user->foto_profil)
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');

    $status = $trx->status;
    $penyewaName = $trx->user ? $trx->user->name : '-';
    $ownerName   = $user->name;
    $foto        = ($trx->barang && $trx->barang->foto_barang)
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
@endphp

<x-profile-layout active="owner" pageTitle="Detail Sewa (Owner)">

    <div class="dash-content-card">
        <div class="profile-avatar" style="position:absolute; top:24px; right:32px; z-index:2;">
            <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
        </div>

        <h2 class="dash-section-title">Rentals Owner</h2>
        <p class="dash-section-sub">Barang yang dimiliki Owner</p>

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
            <div class="rd-field"><label>User</label><div class="rd-value">{{ $penyewaName }}</div></div>
            <div class="rd-field"><label>Informasi Denda</label><div class="rd-value">Rp 10.000/jam</div></div>
            <div class="rd-field"><label>Tanggal Sewa</label><div class="rd-value">{{ optional($trx->tanggal_sewa)->format('d F Y, H.i') ?? '-' }}</div></div>
            <div class="rd-field"><label>Tanggal Pengambilan</label><div class="rd-value">{{ optional($trx->tanggal_kembali_rencana)->format('d F Y, H.i') ?? '-' }}</div></div>
        </div>

        @if($status === 'tunggu verifikasi pengembalian')
        <!-- FORM PENGEMBALIAN -->
        <div class="return-box-title">FORM PENGEMBALIAN</div>

        <div class="return-box">
            <div class="return-box-grid">
                <div>
                    <div class="return-box-field-label">Date Pengembalian Sewa</div>
                    <div class="return-box-value">
                        {{ optional($trx->tanggal_kembali_rencana)->format('d F Y, H.i') ?? '-' }}
                        <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 1.66667H11.6667V0.833333C11.6667 0.61232 11.5789 0.400358 11.4226 0.244078C11.2663 0.0877973 11.0543 0 10.8333 0C10.6123 0 10.4004 0.0877973 10.2441 0.244078C10.0878 0.400358 10 0.61232 10 0.833333V1.66667H5V0.833333C5 0.61232 4.9122 0.400358 4.75592 0.244078C4.59964 0.0877973 4.38768 0 4.16667 0C3.94565 0 3.73369 0.0877973 3.57741 0.244078C3.42113 0.400358 3.33333 0.61232 3.33333 0.833333V1.66667H2.5C1.83696 1.66667 1.20107 1.93006 0.732233 2.3989C0.263392 2.86774 0 3.50363 0 4.16667V14.1667C0 14.8297 0.263392 15.4656 0.732233 15.9344C1.20107 16.4033 1.83696 16.6667 2.5 16.6667H12.5C13.163 16.6667 13.7989 16.4033 14.2678 15.9344C14.7366 15.4656 15 14.8297 15 14.1667V4.16667C15 3.50363 14.7366 2.86774 14.2678 2.3989C13.7989 1.93006 13.163 1.66667 12.5 1.66667ZM4.16667 12.5C4.00185 12.5 3.84073 12.4511 3.70369 12.3596C3.56665 12.268 3.45984 12.1378 3.39677 11.9856C3.33369 11.8333 3.31719 11.6657 3.34935 11.5041C3.3815 11.3424 3.46087 11.194 3.57741 11.0774C3.69395 10.9609 3.84244 10.8815 4.00409 10.8493C4.16574 10.8172 4.3333 10.8337 4.48557 10.8968C4.63784 10.9598 4.76799 11.0667 4.85956 11.2037C4.95113 11.3407 5 11.5018 5 11.6667C5 11.8877 4.9122 12.0996 4.75592 12.2559C4.59964 12.4122 4.38768 12.5 4.16667 12.5ZM10.8333 12.5H7.5C7.27899 12.5 7.06702 12.4122 6.91074 12.2559C6.75446 12.0996 6.66667 11.8877 6.66667 11.6667C6.66667 11.4457 6.75446 11.2337 6.91074 11.0774C7.06702 10.9211 7.27899 10.8333 7.5 10.8333H10.8333C11.0543 10.8333 11.2663 10.9211 11.4226 11.0774C11.5789 11.2337 11.6667 11.4457 11.6667 11.6667C11.6667 11.8877 11.5789 12.0996 11.4226 12.2559C11.2663 12.4122 11.0543 12.5 10.8333 12.5ZM13.3333 7.5H1.66667V4.16667C1.66667 3.94565 1.75446 3.73369 1.91074 3.57741C2.06702 3.42113 2.27899 3.33333 2.5 3.33333H3.33333V4.16667C3.33333 4.38768 3.42113 4.59964 3.57741 4.75592C3.73369 4.9122 3.94565 5 4.16667 5C4.38768 5 4.59964 4.9122 4.75592 4.75592C4.9122 4.59964 5 4.38768 5 4.16667V3.33333H10V4.16667C10 4.38768 10.0878 4.59964 10.2441 4.75592C10.4004 4.9122 10.6123 5 10.8333 5C11.0543 5 11.2663 4.9122 11.4226 4.75592C11.5789 4.59964 11.6667 4.38768 11.6667 4.16667V3.33333H12.5C12.721 3.33333 12.933 3.42113 13.0893 3.57741C13.2455 3.73369 13.3333 3.94565 13.3333 4.16667V7.5Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="return-box-field-label">Denda</div>
                    <div class="return-box-value denda">Rp 0 (Tepat Waktu)</div>
                </div>
            </div>

            <div class="return-box-bottom">
                <div>
                    <div class="return-box-field-label">Foto Barang</div>
                    <div class="return-box-upload">
                        <img src="{{ $foto }}" alt="{{ $trx->barang->nama_barang ?? '' }}" onerror="this.style.display='none'"/>
                    </div>
                </div>
                <div>
                    <div class="return-box-field-label">Review dari Penyewa</div>
                    @if($trx->review)
                        <div class="return-box-stars">
                            <span class="star-on">{{ str_repeat('★', (int) $trx->review->rating) }}</span><span class="star-off">{{ str_repeat('★', max(0, 5 - (int) $trx->review->rating)) }}</span>
                        </div>
                        <div class="return-box-textarea" style="white-space:pre-wrap;">{{ $trx->review->komentar ?: 'Tidak ada ulasan tertulis.' }}</div>
                    @else
                        <div style="color:#8da4be; font-size:13px; padding:8px 0;">Penyewa belum memberi ulasan.</div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('profile.owner.accept', $trx->id) }}" id="acceptReturnForm">
                @csrf
                <button type="submit" class="btn-ajukan-return btn-kirim-return" id="btnAcceptReturn">
                    ACCEPT<br>PENGEMBALIAN
                </button>
            </form>
        </div>
        @else
            <div style="margin-top: 24px; padding: 16px; background: rgba(255,255,255,0.05); border-radius: 12px; color: #8da4be; font-size: 13px;">
                Status: <strong style="color:#fff;">{{ $badgeLabel }}</strong>
                @if($status === 'selesai')
                    — Transaksi ini telah selesai.
                @elseif($status === 'dibatalkan')
                    — Transaksi ini telah dibatalkan.
                @else
                    — Menunggu penyewa mengajukan pengembalian.
                @endif
            </div>
        @endif
    </div>

    <script>
    const badgeBgMap = {
        'upcoming':                        'rgba(235, 245, 48, 0.35)',
        'aktif':                           'rgba(67, 140, 250, 0.35)',
        'tunggu verifikasi pengembalian':  'rgba(250, 164, 67, 0.35)',
        'selesai':                         'rgba(52, 237, 74, 0.35)',
        'dibatalkan':                      'rgba(248, 50, 32, 0.35)',
    };
    const statusLabelMap = {
        'upcoming':                        'Upcoming Rent',
        'aktif':                           'Active Rent',
        'tunggu verifikasi pengembalian':  'Return Rent',
        'selesai':                         'Completed Rent',
        'dibatalkan':                      'Canceled Rent',
    };

    const btnAccept = document.getElementById('btnAcceptReturn');
    if (btnAccept) {
        btnAccept.addEventListener('click', function(e) {
            e.preventDefault();
            const badge = document.getElementById('statusBadge');
            if (badge) {
                badge.textContent = 'Completed Rent';
                badge.style.background = 'rgba(52,237,74,0.35)';
            }
            btnAccept.textContent = 'ACCEPTED ✓';
            btnAccept.style.background = 'rgba(52,237,74,0.6)';
            btnAccept.disabled = true;
            document.getElementById('acceptReturnForm').submit();
        });
    }
    </script>

</x-profile-layout>
