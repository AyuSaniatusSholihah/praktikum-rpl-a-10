@php
    // Data contoh — produk yang sedang diajukan pengembaliannya.
    $trx = [
        'img'   => 'tenda altrek.webp',
        'title' => 'ALLTREK Tenda Camping 1 Bedroom + 1 Guest Room',
        'denda' => 'Rp 15.000 / jam keterlambatan',
    ];
@endphp

<x-profile-layout active="rentals" pageTitle="Form Pengembalian">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals</h2>
        <p class="section-subtitle">Here is your quick overview</p>
    </div>

    <div class="detail-head">
        <img class="detail-img" src="{{ asset('assets/img/' . $trx['img']) }}" alt="{{ $trx['title'] }}">
        <div>
            <span class="rent-badge returning" style="position: static; display: inline-block; margin-bottom: 8px;">Return Rent</span>
            <h3 class="detail-title">{{ $trx['title'] }}</h3>
        </div>
    </div>

    <h3 class="section-divider-title">Form Pengembalian</h3>

    <form class="return-form" action="#" method="POST">
        @csrf

        <div class="info-denda">
            <strong>Informasi Denda</strong><br>
            Denda keterlambatan: {{ $trx['denda'] }}. Pastikan barang dikembalikan tepat waktu &amp; dalam kondisi baik.
        </div>

        <div class="form-group">
            <label>Date Pengembalian Sewa</label>
            <input type="date" value="2026-04-22">
        </div>

        <div class="form-group">
            <label>Kondisi Barang</label>
            <input type="text" placeholder="Contoh: Baik / Ada kerusakan ringan">
        </div>

        <div class="form-group">
            <label>Additional Information</label>
            <textarea rows="4" placeholder="Catatan tambahan untuk owner (opsional)..."></textarea>
        </div>

        <button type="submit" class="btn-kirim">KIRIM PENGEMBALIAN</button>
    </form>

</x-profile-layout>
