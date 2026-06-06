@php
    $barang = $trx->barang;
    $foto   = $barang && $barang->foto_barang ? asset('storage/' . $barang->foto_barang) : asset('assets/img/default-avatar.svg');
    $dendaPerjam = $barang->harga_denda_perjam ?? 0;
@endphp

<x-profile-layout active="rentals" pageTitle="Form Pengembalian">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals</h2>
        <p class="section-subtitle">Ajukan pengembalian barang</p>
    </div>

    <div class="detail-head">
        <img class="detail-img" src="{{ $foto }}" alt="{{ $barang->nama_barang ?? 'Barang' }}">
        <div>
            <span class="rent-badge returning" style="position: static; display: inline-block; margin-bottom: 8px;">Return Rent</span>
            <h3 class="detail-title">{{ $barang->nama_barang ?? 'Barang dihapus' }}</h3>
        </div>
    </div>

    <h3 class="section-divider-title">Form Pengembalian</h3>

    <form class="return-form" action="#" method="POST">
        @csrf

        <div class="info-denda">
            <strong>Informasi Denda</strong><br>
            Denda keterlambatan: Rp {{ number_format($dendaPerjam, 0, ',', '.') }} / jam.
            Batas kembali: {{ optional($trx->tanggal_kembali_rencana)->format('d M Y') ?? '-' }}.
            Pastikan barang dikembalikan tepat waktu &amp; dalam kondisi baik.
        </div>

        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tanggal_kembali" value="{{ now()->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label>Kondisi Barang</label>
            <input type="text" name="kondisi" placeholder="Contoh: Baik / Ada kerusakan ringan">
        </div>

        <div class="form-group">
            <label>Additional Information</label>
            <textarea name="catatan" rows="4" placeholder="Catatan tambahan untuk owner (opsional)..."></textarea>
        </div>

        <button type="submit" class="btn-kirim">KIRIM PENGEMBALIAN</button>
    </form>

</x-profile-layout>
