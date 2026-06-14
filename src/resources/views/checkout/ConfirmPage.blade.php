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
      <p class="confirm-msg">Thank you for buying Goodfeel. The system is grateful to you. Please check your e-mail, there will be a payment link that will be sent to your e-mail address according to your agreement.</p>
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
            $shipping = (isset($order) && $order->shipping_method === 'delivery') ? 20000 : 0;
            $rowTotal = $subtotal + $jaminan + $shipping;
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
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                      style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $trans->tanggal_sewa->format('d F Y') }} <br> {{ \Carbon\Carbon::parse($trans->waktu_sewa)->format('H:i') }} WIB</span>
                </div>
              </div>
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                <div class="rec-date-val">
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                      style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $trans->tanggal_kembali_rencana->format('d F Y') }} <br> {{ \Carbon\Carbon::parse($trans->waktu_kembali_rencana)->format('H:i') }} WIB</span>
                </div>
              </div>
            </div>
            <div class="rec-rows">
              <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $days }} Hari</span></div>
              <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
              <div class="rec-row"><span class="lbl">Shipping</span><span class="val">{{ $shipping > 0 ? 'Rp ' . number_format($shipping, 0, ',', '.') : '-' }}</span></div>
              <div class="rec-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan, 0, ',', '.') }}</span></div>
              <div class="rec-row total-row"><span class="lbl" style="font-weight:700;">Total</span><span class="val">Rp {{ number_format($rowTotal, 0, ',', '.') }}</span></div>
              <div class="rec-row denda"><span class="lbl">#Catatan Denda Pengembalian</span><span class="val">Rp {{ number_format($trans->barang->harga_denda_perjam ?? 15000, 0, ',', '.') }}/jam</span></div>
            </div>
          </div>
        @endforeach










        <!-- Customer Info -->
        <div class="customer-info">
          <h3>Informasi Pesanan</h3>
          <div class="customer-rows">
            <div class="customer-row">
              <div class="clabel">Nama Customer</div>
              <div class="cval">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : (auth()->user()->name ?? '-') }}</div>
            </div>
            <div class="customer-row">
              <div class="clabel">Metode Pengiriman</div>
              <div class="cval">
                  {{ isset($order) && $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}
                  @if(isset($order) && $order->shipping_method == 'delivery' && $order->address)
                      <br> - {{ $order->address }}
                      @if($order->city || $order->kode_pos)
                          , {{ $order->city }} {{ $order->kode_pos }}
                      @endif
                  @endif
              </div>
            </div>
            <div class="customer-row">
              <div class="clabel">Metode Pembayaran</div>
              <div class="cval">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</div>
            </div>

            <div class="customer-row" style="grid-column: 1 / -1;">
              <div class="clabel">Waktu Pemesanan</div>
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