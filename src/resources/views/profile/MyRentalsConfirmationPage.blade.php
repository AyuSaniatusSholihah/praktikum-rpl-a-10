@php
    $barang = $trx->barang;
@endphp

<x-profile-layout active="rentals" pageTitle="Confirmation">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals</h2>
        <p class="section-subtitle">Konfirmasi pengembalian: {{ $barang->nama_barang ?? 'Barang' }}</p>
    </div>

    <div class="confirm-window">
        <h3>Enter The Confirmation Code</h3>
        <p>Enter the 4-digit code sent to <strong>{{ $user->email }}</strong></p>

        <form action="#" method="POST">
            @csrf
            <div class="confirm-code-boxes">
                <input type="text" maxlength="1" class="code-box" inputmode="numeric">
                <input type="text" maxlength="1" class="code-box" inputmode="numeric">
                <input type="text" maxlength="1" class="code-box" inputmode="numeric">
                <input type="text" maxlength="1" class="code-box" inputmode="numeric">
            </div>

            <span class="confirm-resend">
                Didn&rsquo;t receive Confirmation Code? <a href="#">Resend Now</a>
            </span>

            <button type="submit" class="btn-kirim">KIRIM PENGEMBALIAN</button>
        </form>

        <div class="confirm-status">
            <i class="fa-solid fa-clock"></i>
            Status Return Rent Anda saat ini: MENUNGGU VERIFIKASI OWNER
        </div>
    </div>

</x-profile-layout>
