@php
    // Data contoh — siap diganti detail TransaksiPenyewaan yang dipilih.
    $trx = [
        'img'      => 'tenda altrek.webp',
        'title'    => 'ALLTREK Tenda Camping 1 Bedroom + 1 Guest Room',
        'id'       => 'T0002',
        'owner'    => 'Camping Groups Bandung',
        'user'     => 'Aprilia Alfa',
        'denda'    => '-',
        'date'     => '12 Maret 2026, 09.45 AM',
        'status'   => 'Active Rent',
        'receiptName' => 'ALLTREK Tenda Camping Tentastic Outdoor 1 Bedroom + 1 Guest Room',
        'perday'   => 'Rp 450.000/hari',
        'mulai'    => '30 Juli 2026',
        'selesai'  => '32 Juli 2026',
        'durasi'   => '2 Hari',
        'subtotal' => 'Rp 900.000',
        'shipping' => 'Rp 40.000',
        'jaminan'  => 'Rp 450.000',
        'total'    => 'Rp 1.750.000',
        'denda_note' => 'Rp 15.000/jam',
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

    <div class="detail-head">
        <img class="detail-img" src="{{ asset('assets/img/' . $trx['img']) }}" alt="{{ $trx['title'] }}">
        <h3 class="detail-title">{{ $trx['title'] }}</h3>
    </div>

    <div class="detail-form-grid">
        <div class="form-group">
            <label>ID Transaction</label>
            <input type="text" value="{{ $trx['id'] }}" readonly>
        </div>
        <div class="form-group">
            <label>Owner</label>
            <input type="text" value="{{ $trx['owner'] }}" readonly>
        </div>
        <div class="form-group">
            <label>User</label>
            <input type="text" value="{{ $trx['user'] }}" readonly>
        </div>
        <div class="form-group">
            <label>Denda</label>
            <input type="text" value="{{ $trx['denda'] }}" readonly>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="text" value="{{ $trx['date'] }}" readonly>
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text" value="{{ $trx['status'] }}" readonly>
        </div>
    </div>

    <h3 class="section-divider-title">Receipt</h3>
    <div class="receipt-card">
        <div class="receipt-head">
            <img class="receipt-img" src="{{ asset('assets/img/' . $trx['img']) }}" alt="{{ $trx['receiptName'] }}">
            <div>
                <div class="receipt-prodname">{{ $trx['receiptName'] }}</div>
                <div class="receipt-perday">{{ $trx['perday'] }}</div>
                <div class="receipt-dates">
                    <div>
                        <div class="lbl">Tanggal Mulai Penyewaan</div>
                        <div class="val"><i class="fa-regular fa-calendar"></i> {{ $trx['mulai'] }}</div>
                    </div>
                    <div>
                        <div class="lbl">Tanggal Selesai Penyewaan</div>
                        <div class="val"><i class="fa-regular fa-calendar"></i> {{ $trx['selesai'] }}</div>
                    </div>
                </div>
            </div>
            <span class="paid-badge">PAID</span>
        </div>

        <div class="receipt-rows">
            <div class="receipt-row"><span>Durasi Sewa</span><span>{{ $trx['durasi'] }}</span></div>
            <div class="receipt-row"><span>Subtotal</span><span>{{ $trx['subtotal'] }}</span></div>
            <div class="receipt-row"><span>Shipping</span><span>{{ $trx['shipping'] }}</span></div>
            <div class="receipt-row"><span>Jaminan</span><span>{{ $trx['jaminan'] }}</span></div>
            <div class="receipt-row total"><span>Total</span><span>{{ $trx['total'] }}</span></div>
            <div class="receipt-row note"><span>#Catatan Denda Pengembalian</span><span>{{ $trx['denda_note'] }}</span></div>
        </div>
    </div>

</x-profile-layout>
