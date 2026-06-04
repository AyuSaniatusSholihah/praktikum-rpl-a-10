@props(['barang'])

@php
    $imgUrl = $barang->foto_barang
        ? asset('storage/' . $barang->foto_barang)
        : 'https://placehold.co/400x300?text=No+Image';

    $isActive = strtolower($barang->status ?? '') === 'disewa';
    $badgeLabel = $isActive ? 'ACTIVE RENTAL' : 'AVAILABLE';
    $badgeClass = $isActive ? 'katalog-badge active' : 'katalog-badge';
    $stok = (int) $barang->stok;
@endphp

<article class="katalog-card"
         style="cursor: pointer;"
         onclick="prepareEdit({{ $barang->id }})"
         data-id="{{ $barang->id }}"
         data-title="{{ $barang->nama_barang }}"
         data-loc="{{ $barang->lokasi }}"
         data-price="{{ (int) $barang->harga_sewa }}"
         data-stock="{{ $stok }}"
         data-status="{{ $barang->status }}"
         data-img="{{ $imgUrl }}"
         data-deskripsi="{{ $barang->deskripsi }}"
         data-add-info="{{ $barang->additional_info ?? '' }}"
         data-kategori="{{ $barang->kategori->nama_kategori ?? 'Camping' }}"
         data-tgl-mulai="{{ $barang->tanggal_item_mulai }}"
         data-tgl-selesai="{{ $barang->tanggal_item_tidak_tersedia }}"
         data-wa="{{ $barang->user->phone_number ?? '0821-5620-9034' }}"
         data-jaminan="{{ $barang->harga_jaminan }}"
         data-denda="{{ $barang->harga_denda_perjam }}">

    <span class="{{ $badgeClass }}">{{ $badgeLabel }}</span>

    <div class="product-img">
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

    <div class="stock-footer">
        <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.4997 5.16667V16H2.49967V5.16667M8.33301 8.5H11.6663M0.833008 1H19.1663V5.16667H0.833008V1Z"
                  stroke="#484848" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="stock-text-only" style="position: relative; top: 1px;">
            {{ $stok }} {{ $stok === 1 ? 'Unit' : 'Units' }} in Stock
        </span>
    </div>
</article>
