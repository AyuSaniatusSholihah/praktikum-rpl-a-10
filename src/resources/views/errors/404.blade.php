<x-layout title="404 Halaman Tidak Ditemukan — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}" />
    </x-slot:styles>

    <div class="illustration-wrap">
        <img src="{{ asset('assets/img/error.png') }}" alt="Error Gambar" />
    </div>

    <div class="text-block">
        <h1 class="title-404">404</h1>
        <p class="subtitle">Halaman yang Anda cari tidak ditemukan.</p>
        <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>
    </div>
</x-layout>