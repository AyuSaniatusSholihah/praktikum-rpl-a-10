@props(['barang'])

@php
    $imgUrl = $barang->foto_barang
        ? asset('storage/' . $barang->foto_barang)
        : 'https://placehold.co/400x300?text=No+Image';

    $kategori = strtolower($barang->kategori->nama_kategori ?? 'others');
@endphp

<article class="rental-card"
         style="cursor: pointer;"
         onclick="location.href='{{ route('product', $barang->id) }}'"
         data-id="{{ $barang->id }}"
         data-title="{{ strtolower($barang->nama_barang) }}"
         data-category="{{ $kategori }}"
         data-loc="{{ strtolower($barang->lokasi) }}"
         data-price="{{ (int) $barang->harga_sewa }}">

    <div class="rental-img">
        <img src="{{ $imgUrl }}"
             alt="{{ $barang->nama_barang }}"
             onerror="this.style.display='none'" />
    </div>

    <div class="head-row">
        <h4>{{ $barang->nama_barang }}</h4>
        <span class="rating">★★★★★</span>
    </div>

    <div class="loc">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        {{ $barang->lokasi }}
    </div>

    <div class="reviews">(0) Customer Reviews</div>

    <div class="price">Rp {{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</div>
</article>
