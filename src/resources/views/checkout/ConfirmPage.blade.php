<x-layout title="Payment Confirmed — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}" />
    </x-slot:styles>

  <!-- Page Header -->
  <div class="page-header">
    <h1>Checkout Payment</h1>
    <div class="breadcrumb-nav">
      <a href="{{ route('home') }}">Home</a>
      <span class="sep">›</span>
      <a href="{{ route('rentals') }}">Rentals</a>
      <span class="sep">›</span>
      <span class="current">Checkout Payment</span>
    </div>
  </div>




  <main class="checkout-main">
    <!-- Left: Confirmation Status -->
    <div class="confirm-side">
      <div class="check-circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div class="confirm-title">PAYMENT CONFIRMED!</div>
      <div class="confirm-order">ORDER <strong>#{{ $pembayaran->id ?? '-' }}</strong></div>
      <p class="confirm-msg">Terima kasih telah memesan di SEWAIN! Pesanan kamu sedang diproses. Silakan cek email kamu untuk detail lebih lanjut.</p>
      <a href="{{ route('home') }}" class="btn-home">Back to SEWAIN Home</a>
      <button class="link-print" onclick="window.print()">Print Receipt</button>
    </div>




    <!-- Right: Receipt Detail -->
    <div class="receipt-side">
      <div class="receipt-card">
        @foreach($transaksis as $trans)
          @php
            $days = $trans->tanggal_sewa->diffInDays($trans->tanggal_kembali_rencana);
            if ($days == 0) $days = 1;
            $subtotal = ($trans->barang->harga_sewa ?? 0) * $trans->jumlah * $days;
            $jaminan  = round(($trans->barang->harga_sewa ?? 0) * $trans->jumlah / 2);
            $rowTotal = $subtotal + $jaminan;
          @endphp
          <div class="receipt-product">
            <div class="receipt-product-header">
              <div class="item-badge">{{ $trans->jumlah }}</div>
              <div class="rec-img">
                <img src="{{ $trans->barang->foto_barang ? asset('storage/'.$trans->barang->foto_barang) : 'https://placehold.co/60x60?text=Foto' }}" alt="{{ $trans->barang->nama_barang }}">
              </div>
              <div class="rec-product-info">
                <div class="rec-product-name">{{ $trans->barang->nama_barang }}</div>
                <div class="rec-price">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</div>
              </div>
              <span class="paid-badge">PAID</span>
            </div>
            <div class="rec-dates">
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Mulai Penyewaan</div>
                <div class="rec-date-val">
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $trans->tanggal_sewa->format('d F Y') }}</span>
                </div>
              </div>
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                <div class="rec-date-val">
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $trans->tanggal_kembali_rencana->format('d F Y') }}</span>
                </div>
              </div>
            </div>
            <div class="rec-rows">
              <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $days }} Hari</span></div>
              <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
              <div class="rec-row"><span class="lbl">Shipping</span><span class="val">-</span></div>
              <div class="rec-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan, 0, ',', '.') }}</span></div>
              <div class="rec-row total-row"><span class="lbl" style="font-weight:700;">Total</span><span class="val">Rp {{ number_format($rowTotal, 0, ',', '.') }}</span></div>
              <div class="rec-row denda"><span class="lbl">#Catatan Denda Pengembalian</span><span class="val">Rp 15.000/jam</span></div>
            </div>
          </div>
        @endforeach










        <!-- Customer Info -->
        <div class="customer-info">
          <h3>Informasi Pesanan</h3>
          <div class="customer-rows">
            <div class="customer-row">
              <div class="clabel">Metode Pembayaran</div>
              <div class="cval">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</div>
            </div>
            <div class="customer-row">
              <div class="clabel">Total Pembayaran</div>
              <div class="cval">Rp {{ number_format($pembayaran->jumlah_bayar ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="customer-row" style="grid-column: 1 / -1;">
              <div class="clabel">Tanggal Pembayaran</div>
              <div class="cval">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d F Y, H:i') . ' WIB' : '-' }}</div>
            </div>
          </div>
        </div>

        <div class="receipt-logo">SEWA<span>IN</span></div>
      </div>
    </div>
  </main>

<x-slot:scripts>
<script>
  // No localStorage needed — data is server-rendered from the database
</script>
</x-slot:scripts>
</x-layout>