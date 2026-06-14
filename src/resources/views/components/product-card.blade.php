@props(['barang'])

<article class="product-card" onclick="location.href='{{ route('product', $barang->id) }}'">
    <div class="product-img">
        <img src="{{ $barang->foto_barang ? asset('storage/' . $barang->foto_barang) : 'https://placehold.co/400x300?text=No+Image' }}" alt="{{ $barang->nama_barang }}" />
    </div>
    @php
        $reviewCount = $barang->reviews()->count();
        $avgRating = $reviewCount > 0 ? round($barang->reviews()->avg('rating'), 1) : 0;
        $stars = '';
        for($i=1; $i<=5; $i++) {
            $stars .= ($i <= round($avgRating)) ? '★' : '☆';
        }
        if ($reviewCount == 0) $stars = '★★★★★';
    @endphp
    <div class="head-row">
        <h4>{{ $barang->nama_barang }}</h4>
        <span class="rating">{{ $stars }}</span>
    </div>
    <div class="loc">
        <x-icons.location style="width:14px;height:14px;margin-right:4px;" />
        {{ $barang->lokasi }}
    </div>
    <div class="reviews">({{ $reviewCount }}) Customer Reviews</div>
    <div class="price">Rp {{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</div>
</article>
