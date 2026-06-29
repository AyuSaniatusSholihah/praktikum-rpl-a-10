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
                    position:absolute; top:2px; left:-15px;
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
            <div class="rd-field"><label>User</label><div class="rd-value">{{ $penyewaName }}</div></div>
            <div class="rd-field"><label>Informasi Denda</label><div class="rd-value">Rp 10.000/jam</div></div>
            <div class="rd-field"><label>Tanggal Sewa</label><div class="rd-value">{{ optional($trx->tanggal_sewa)->format('d F Y') ?? '-' }}, {{ $trx->waktu_sewa ? \Carbon\Carbon::parse($trx->waktu_sewa)->format('H.i') : '08.00' }} WIB</div></div>
            <div class="rd-field"><label>Tanggal Pengembalian</label><div class="rd-value">{{ optional($trx->tanggal_kembali_rencana)->format('d F Y') ?? '-' }}, {{ $trx->waktu_kembali_rencana ? \Carbon\Carbon::parse($trx->waktu_kembali_rencana)->format('H.i') : '08.00' }} WIB</div></div>
        </div>

        @if($status === 'tunggu verifikasi pengembalian')
        <!-- FORM PENGEMBALIAN -->
        <div class="return-box-title">FORM PENGEMBALIAN</div>

        <div class="return-box">
            <div class="return-box-grid">
                <div>
                    <div class="return-box-field-label">Date Pengembalian Sewa</div>
                    <div class="return-box-value">
                        {{ optional($trx->tanggal_kembali_aktual)->format('d F Y, H.i') ?? optional($trx->tanggal_kembali_rencana)->format('d F Y') ?? '-' }} WIB
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
                    <div class="return-box-field-label">Foto Bukti Pengembalian</div>
                    <div class="return-box-upload">
                        <img src="{{ $trx->foto_buktipengembalian ? asset('storage/' . $trx->foto_buktipengembalian) : '' }}" alt="Foto Bukti Pengembalian" onerror="this.style.display='none'"/>
                    </div>
                </div>
                <div>
                    <div class="return-box-field-label">Review dari Penyewa</div>
                    @if($trx->review)
                        <div style="display:flex; gap:12px; align-items:flex-start;">
                            <div style="width:44px; height:44px; border-radius:50%; background:#d6d6d6; flex-shrink:0; overflow:hidden">
                                <img src="{{ ($trx->review->user && $trx->review->user->foto_profil) ? asset('storage/' . $trx->review->user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($trx->review->user->name ?? 'U') }}" style="width:100%; height:100%; object-fit:cover"/>
                            </div>
                            <div style="flex:1">
                                <div class="return-box-stars">
                                    <span class="star-on">{{ str_repeat('★', (int) $trx->review->rating) }}</span><span class="star-off">{{ str_repeat('★', max(0, 5 - (int) $trx->review->rating)) }}</span>
                                </div>
                                <div class="return-box-textarea" style="white-space:pre-wrap; margin-top:6px;">{{ $trx->review->komentar ?: 'Tidak ada ulasan tertulis.' }}</div>
                            </div>
                        </div>
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
        @elseif($status === 'selesai')
            <div class="confirmed-box" style="margin-top:24px;">
                <div class="check">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <h3>ACCEPT RETURN CONFIRMED!</h3>
                <p>
                    Terima Kasih telah menggunakan Website SEWAIN sebagai platform penyewaan Anda!
                </p>
                <p>Status Return Rent anda saat ini:<br>
                    <strong>COMPLETED RENT ✓</strong>
                </p>
            </div>
        @else
            <div style="margin-top: 24px; padding: 16px; background: rgba(255,255,255,0.05); border-radius: 12px; color: #8da4be; font-size: 13px; margin-left: calc(70px + 18px);">
                Status: <strong style="color:#fff;">{{ $badgeLabel }}</strong>
                @if($status === 'dibatalkan')
                    — Transaksi ini telah dibatalkan.
                @else
                    — Menunggu penyewa mengajukan pengembalian.
                @endif
            </div>
        @endif

        {{-- Receipt ringkas untuk owner (pendapatan dari transaksi ini) --}}
        @php
            $durasi = 0;
            if ($trx->tanggal_sewa && $trx->tanggal_kembali_rencana) {
                $durasi = $trx->tanggal_sewa->diffInDays($trx->tanggal_kembali_rencana) ?: 1;
            }
            $hargaPerHari = $trx->barang->harga_sewa ?? 0;
            $subtotal     = $hargaPerHari * $trx->jumlah * $durasi;
            $jaminan      = ($trx->barang->harga_jaminan ?? 0) * $trx->jumlah;
        @endphp
        <div id="reviews-section" style="margin-top:24px;">
            <div class="reviews-header">
                <h3>Receipt</h3>
            </div>

            <div class="receipt-item">
                <div class="receipt-product">
                    <div class="receipt-product-header">
                        <div class="item-badge">{{ $trx->jumlah }}</div>
                        <div class="rec-img">
                            <img src="{{ $trx->foto_buktipengembalian ? asset('storage/' . $trx->foto_buktipengembalian) : $foto }}" onerror="this.style.display='none'">
                        </div>
                        <div class="rec-product-info">
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
                                <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                              </svg>
                              <span>{{ optional($trx->tanggal_sewa)->format('d F Y') ?? '-' }}<br>{{ $trx->waktu_sewa ? \Carbon\Carbon::parse($trx->waktu_sewa)->format('H.i') : '08.00' }} WIB</span>
                            </div>
                        </div>
                        <div class="rec-date-item">
                            <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                            <div class="rec-date-val">
                              <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                                <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                              </svg>
                              <span>{{ optional($trx->tanggal_kembali_rencana)->format('d F Y') ?? '-' }}<br>{{ $trx->waktu_kembali_rencana ? \Carbon\Carbon::parse($trx->waktu_kembali_rencana)->format('H.i') : '08.00' }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="rec-rows">
                        <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $durasi }} Hari</span></div>
                        <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                        <div class="rec-row"><span class="lbl">Shipping</span><span class="val">-</span></div>
                        <div class="rec-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan, 0, ',', '.') }}</span></div>
                        <div class="rec-row total-row"><span class="lbl" style="font-weight:700;">Total</span><span class="val">Rp {{ number_format($trx->total_harga ?? $subtotal, 0, ',', '.') }}</span></div>
                        <div class="rec-row denda"><span class="lbl">#Catatan Denda Pengembalian</span><span class="val">Rp {{ number_format(optional($trx->barang)->harga_denda_perjam ?? 15000, 0, ',', '.') }}/jam</span></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
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
