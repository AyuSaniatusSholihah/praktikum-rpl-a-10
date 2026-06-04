<x-layout>
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}" />
    </x-slot:styles>

    <section class="error-page">
        <div class="container">
            <h1>404</h1>
            <p>Halaman yang Anda cari tidak ditemukan.</p>
            
            <img src="{{ asset('assets/images/error.png') }}" class="error-img" style="max-width:100%; height:auto; margin-top:1rem;" alt="Error Gambar"/>
            
            <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>
        </div>
    </section>
</x-layout>