@php
    $fotoProfil = ($user && $user->foto_profil)
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');
@endphp

<x-profile-layout active="wallet" pageTitle="My Wallet">
    <div class="dash-content-card">
        <div class="profile-avatar" style="position:absolute; top:24px; right:32px; z-index:2;">
            <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
        </div>
        
        <h2 class="dash-section-title">My Wallet</h2>
        <p class="dash-section-sub">Informasi Keuangan User</p>
        
        <div class="dash-cards" id="ownerActive"></div>
        
        <div class="profile-grid">
            <!-- LEFT -->
            <div class="profile-left">
                <div class="profile-field">
                    <label for="accName">Name Account User</label>
                    <input type="text" id="accName" value="{{ $user->name }}" readonly/>
                </div>
                <div class="profile-field">
                    <label for="accEmail">Email</label>
                    <input type="email" id="accEmail" value="{{ $user->email }}" readonly/>
                </div>
                <div class="profile-field">
                    <label for="accRek">Informasi Rekening</label>
                    <textarea id="accRek" rows="4" placeholder="Belum ada informasi rekening" readonly>Nama Rekening: BCA&#10;No Rekening: 1234567890&#10;A/n: {{ $user->name }}</textarea>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="profile-right">
                <div class="saldo-card">
                    <svg class="saldo-bg" width="350" height="200" viewBox="0 0 350 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M255.086 5.97015C248.348 16.0669 244.419 28.1983 244.419 41.2475V45.3198C244.419 80.4647 272.911 108.956 308.056 108.956C321.486 108.955 333.944 104.794 344.213 97.6909V176C344.213 189.255 333.468 200 320.213 200H24C10.7453 200 0.000164583 189.255 0 176V29.9702C1.05835e-05 16.7153 10.7452 5.97015 24 5.97015H255.086Z" fill="#B2C9DD"/>
                        <rect x="266.617" y="0.5" width="82.8838" height="85.5672" rx="29.5" fill="white" fill-opacity="0.16" stroke="url(#paint0_linear)"/>
                        <rect x="34.7129" y="29.8508" width="44" height="23" rx="6" fill="white" fill-opacity="0.5"/>
                        <text x="38" y="46" font-family="Inter" font-size="11" font-weight="600" fill="#1D4734">+2.3%</text>
                        <g clip-path="url(#clip0)">
                            <path d="M308.057 26.8657V35.0747M308.057 59.7015V51.4926" stroke="#B2C9DD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M315.288 32.8358H304.441C303.098 32.8358 301.811 33.3862 300.862 34.3659C299.912 35.3456 299.379 36.6743 299.379 38.0597C299.379 39.4452 299.912 40.7739 300.862 41.7536C301.811 42.7332 303.098 43.2836 304.441 43.2836H311.672C313.015 43.2836 314.302 43.834 315.252 44.8137C316.201 45.7933 316.734 47.122 316.734 48.5075C316.734 49.893 316.201 51.2217 315.252 52.2013C314.302 53.181 313.015 53.7314 311.672 53.7314H299.379" stroke="#B2C9DD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <linearGradient id="paint0_linear" x1="319.629" y1="-100" x2="301.152" y2="151.41" gradientUnits="userSpaceOnUse">
                                <stop stop-color="white" stop-opacity="0.58"/>
                                <stop offset="1" stop-color="#B2C9DD" stop-opacity="0"/>
                            </linearGradient>
                            <clipPath id="clip0">
                                <rect width="34.7105" height="35.8209" fill="white" transform="translate(290.701 25.3732)"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <div class="saldo-texts">
                        <div class="saldo-label">Saldo</div>
                        <div class="saldo-amount">Rp {{ number_format($user->saldo ?? 0, 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="dash-section-title history">My Wallet — History</h2>
        <p class="dash-section-sub">Riwayat penyewaan barangmu oleh penyewa.</p>
        
        <div class="txn-grid">
            @forelse($transaksi as $key => $t)
                @php
                    $cid = 'wc' . $key;
                    $badgeClass = 'pembayaran-badge';
                    $badgeText = 'Pembayaran Sewa';
                    $amountPrefix = '-';
                    // Jika barang yang disewa adalah milik user ini, maka ini pemasukan
                    if ($t->barang && $t->barang->user_id === $user->id) {
                        $badgeClass = 'pemasukan-badge';
                        $badgeText = 'Pemasukan Sewa';
                        $amountPrefix = '+';
                    }
                    $foto = $t->barang && $t->barang->foto_barang ? asset('storage/' . $t->barang->foto_barang) : asset('assets/img/default-avatar.svg');
                @endphp
                <div class="txn-card-1-wrapper">
                    <div class="txn-card">
                        <div class="txn-img-wrap">
                            <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                            <div class="txn-foto">
                                <svg width="238" height="169" viewBox="0 0 238 169" fill="none">
                                    <clipPath id="{{ $cid }}">
                                        <path d="M19.0299 20.3268C20.8415 8.62969 30.9106 0 42.7471 0L213.215 0C228.845 0 240.304 14.7009 236.49 29.8575L206.037 150.858C203.353 161.524 193.761 169 182.763 169H24.0071C9.2881 169 -1.96293 155.872 0.289844 141.327L19.0299 20.3268Z"/>
                                    </clipPath>
                                    <path d="M19.0299 20.3268C20.8415 8.62969 30.9106 0 42.7471 0L213.215 0C228.845 0 240.304 14.7009 236.49 29.8575L206.037 150.858C203.353 161.524 193.761 169 182.763 169H24.0071C9.2881 169 -1.96293 155.872 0.289844 141.327L19.0299 20.3268Z" fill="#2d4a61"/>
                                    <image href="{{ $foto }}" x="0" y="0" width="238" height="169"
                                        preserveAspectRatio="xMidYMid slice" clip-path="url(#{{ $cid }})"/>
                                </svg>
                            </div>
                        </div>
                        <div class="txn-card-info">
                            <h5>{{ $t->barang->nama_barang ?? 'Barang dihapus' }}</h5>
                            <div class="loc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $t->barang->alamat ?? 'Lokasi tidak diketahui' }}
                            </div>
                            <div class="amount">{{ $amountPrefix }} Rp {{ number_format($t->total_harga ?? 0, 0, ',', '.') }}</div>
                            <div class="date-row">
                                <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_4266_1491)"><path d="M12.5 1.66667H11.6667V0.833333C11.6667 0.61232 11.5789 0.400358 11.4226 0.244078C11.2663 0.0877973 11.0543 0 10.8333 0C10.6123 0 10.4004 0.0877973 10.2441 0.244078C10.0878 0.400358 10 0.61232 10 0.833333V1.66667H5V0.833333C5 0.61232 4.9122 0.400358 4.75592 0.244078C4.59964 0.0877973 4.38768 0 4.16667 0C3.94565 0 3.73369 0.0877973 3.57741 0.244078C3.42113 0.400358 3.33333 0.61232 3.33333 0.833333V1.66667H2.5C1.83696 1.66667 1.20107 1.93006 0.732233 2.3989C0.263392 2.86774 0 3.50363 0 4.16667V14.1667C0 14.8297 0.263392 15.4656 0.732233 15.9344C1.20107 16.4033 1.83696 16.6667 2.5 16.6667H12.5C13.163 16.6667 13.7989 16.4033 14.2678 15.9344C14.7366 15.4656 15 14.8297 15 14.1667V4.16667C15 3.50363 14.7366 2.86774 14.2678 2.3989C13.7989 1.93006 13.163 1.66667 12.5 1.66667ZM4.16667 12.5C4.00185 12.5 3.84073 12.4511 3.70369 12.3596C3.56665 12.268 3.45984 12.1378 3.39677 11.9856C3.33369 11.8333 3.31719 11.6657 3.34935 11.5041C3.3815 11.3424 3.46087 11.194 3.57741 11.0774C3.69395 10.9609 3.84244 10.8815 4.00409 10.8493C4.16574 10.8172 4.3333 10.8337 4.48557 10.8968C4.63784 10.9598 4.76799 11.0667 4.85956 11.2037C4.95113 11.3407 5 11.5018 5 11.6667C5 11.8877 4.9122 12.0996 4.75592 12.2559C4.59964 12.4122 4.38768 12.5 4.16667 12.5ZM10.8333 12.5H7.5C7.27899 12.5 7.06702 12.4122 6.91074 12.2559C6.75446 12.0996 6.66667 11.8877 6.66667 11.6667C6.66667 11.4457 6.75446 11.2337 6.91074 11.0774C7.06702 10.9211 7.27899 10.8333 7.5 10.8333H10.8333C11.0543 10.8333 11.2663 10.9211 11.4226 11.0774C11.5789 11.2337 11.6667 11.4457 11.6667 11.6667C11.6667 11.8877 11.5789 12.0996 11.4226 12.2559C11.2663 12.4122 11.0543 12.5 10.8333 12.5ZM13.3333 7.5H1.66667V4.16667C1.66667 3.94565 1.75446 3.73369 1.91074 3.57741C2.06702 3.42113 2.27899 3.33333 2.5 3.33333H3.33333V4.16667C3.33333 4.38768 3.42113 4.59964 3.57741 4.75592C3.73369 4.9122 3.94565 5 4.16667 5C4.38768 5 4.59964 4.9122 4.75592 4.75592C4.9122 4.59964 5 4.38768 5 4.16667V3.33333H10V4.16667C10 4.38768 10.0878 4.59964 10.2441 4.75592C10.4004 4.9122 10.6123 5 10.8333 5C11.0543 5 11.2663 4.9122 11.4226 4.75592C11.5789 4.59964 11.6667 4.38768 11.6667 4.16667V3.33333H12.5C12.721 3.33333 12.933 3.42113 13.0893 3.57741C13.2455 3.73369 13.3333 3.94565 13.3333 4.16667V7.5Z" fill="white"/></g><defs><clipPath id="clip0_4266_1491"><rect width="15" height="17" fill="white"/></clipPath></defs></svg>
                                Tanggal Sewa: {{ optional($t->tanggal_sewa)->format('d/m/Y') ?? '-' }} s.d {{ optional($t->tanggal_kembali_rencana)->format('d/m/Y') ?? '-' }}
                            </div>
                            <div class="date-row">
                                <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_4266_1491)"><path d="M12.5 1.66667H11.6667V0.833333C11.6667 0.61232 11.5789 0.400358 11.4226 0.244078C11.2663 0.0877973 11.0543 0 10.8333 0C10.6123 0 10.4004 0.0877973 10.2441 0.244078C10.0878 0.400358 10 0.61232 10 0.833333V1.66667H5V0.833333C5 0.61232 4.9122 0.400358 4.75592 0.244078C4.59964 0.0877973 4.38768 0 4.16667 0C3.94565 0 3.73369 0.0877973 3.57741 0.244078C3.42113 0.400358 3.33333 0.61232 3.33333 0.833333V1.66667H2.5C1.83696 1.66667 1.20107 1.93006 0.732233 2.3989C0.263392 2.86774 0 3.50363 0 4.16667V14.1667C0 14.8297 0.263392 15.4656 0.732233 15.9344C1.20107 16.4033 1.83696 16.6667 2.5 16.6667H12.5C13.163 16.6667 13.7989 16.4033 14.2678 15.9344C14.7366 15.4656 15 14.8297 15 14.1667V4.16667C15 3.50363 14.7366 2.86774 14.2678 2.3989C13.7989 1.93006 13.163 1.66667 12.5 1.66667ZM4.16667 12.5C4.00185 12.5 3.84073 12.4511 3.70369 12.3596C3.56665 12.268 3.45984 12.1378 3.39677 11.9856C3.33369 11.8333 3.31719 11.6657 3.34935 11.5041C3.3815 11.3424 3.46087 11.194 3.57741 11.0774C3.69395 10.9609 3.84244 10.8815 4.00409 10.8493C4.16574 10.8172 4.3333 10.8337 4.48557 10.8968C4.63784 10.9598 4.76799 11.0667 4.85956 11.2037C4.95113 11.3407 5 11.5018 5 11.6667C5 11.8877 4.9122 12.0996 4.75592 12.2559C4.59964 12.4122 4.38768 12.5 4.16667 12.5ZM10.8333 12.5H7.5C7.27899 12.5 7.06702 12.4122 6.91074 12.2559C6.75446 12.0996 6.66667 11.8877 6.66667 11.6667C6.66667 11.4457 6.75446 11.2337 6.91074 11.0774C7.06702 10.9211 7.27899 10.8333 7.5 10.8333H10.8333C11.0543 10.8333 11.2663 10.9211 11.4226 11.0774C11.5789 11.2337 11.6667 11.4457 11.6667 11.6667C11.6667 11.8877 11.5789 12.0996 11.4226 12.2559C11.2663 12.4122 11.0543 12.5 10.8333 12.5ZM13.3333 7.5H1.66667V4.16667C1.66667 3.94565 1.75446 3.73369 1.91074 3.57741C2.06702 3.42113 2.27899 3.33333 2.5 3.33333H3.33333V4.16667C3.33333 4.38768 3.42113 4.59964 3.57741 4.75592C3.73369 4.9122 3.94565 5 4.16667 5C4.38768 5 4.59964 4.9122 4.75592 4.75592C4.9122 4.59964 5 4.38768 5 4.16667V3.33333H10V4.16667C10 4.38768 10.0878 4.59964 10.2441 4.75592C10.4004 4.9122 10.6123 5 10.8333 5C11.0543 5 11.2663 4.9122 11.4226 4.75592C11.5789 4.59964 11.6667 4.38768 11.6667 4.16667V3.33333H12.5C12.721 3.33333 12.933 3.42113 13.0893 3.57741C13.2455 3.73369 13.3333 3.94565 13.3333 4.16667V7.5Z" fill="white"/></g><defs><clipPath id="clip0_4266_1491"><rect width="15" height="17" fill="white"/></clipPath></defs></svg>
                                Tanggal Transaksi: {{ optional($t->created_at)->format('d/m/Y') ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color:#8da4be; font-size:13px; margin-top:20px; grid-column:1/-1;">Belum ada riwayat transaksi dompet.</p>
            @endforelse
        </div>
    </div>

    <x-slot:styles>
        <style>
            .wallet-history-empty {
                text-align: center;
                color: #8da4be;
                padding: 40px;
                grid-column: 1/-1;
            }
        </style>
    </x-slot:styles>

    <script>
    function adjustTxnShape() {
        document.querySelectorAll('.txn-card').forEach(card => {
            const cardHeight = card.offsetHeight;
            const scale = cardHeight / 355;
            card.style.setProperty('--scale-y', scale);
        });
    }
    setTimeout(adjustTxnShape, 100);
    window.addEventListener('load', adjustTxnShape);
    window.addEventListener('resize', adjustTxnShape);
    </script>
</x-profile-layout>
