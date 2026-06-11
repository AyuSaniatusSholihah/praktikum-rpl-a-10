<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; color: #181A18; }
        .receipt-card { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #1A1F71; margin: 0; font-size: 22px; }
        .order-id { font-weight: bold; color: #333; margin-top: 5px; font-size: 14px; }
        
        .receipt-product { border: 1px solid #e0e0e0; border-radius: 10px; padding: 16px; margin-bottom: 20px; }
        .receipt-product-header { border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 12px; }
        .item-badge { display: inline-block; background: #1A1F71; color: #fff; width: 24px; height: 24px; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: bold; margin-right: 12px; vertical-align: middle; }
        .rec-product-info { display: inline-block; vertical-align: middle; }
        .rec-product-name { font-weight: 600; font-size: 14px; margin-bottom: 4px; }
        .rec-price { font-size: 13px; color: #666; }
        .paid-badge { float: right; background: #E8F5E9; color: #2E7D32; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; margin-top: 5px; }
        
        .rec-date-item { margin-bottom: 8px; }
        .rec-date-label { font-size: 11px; color: #777; text-transform: uppercase; margin-bottom: 2px; }
        .rec-date-val { font-size: 13px; font-weight: 500; }
        
        .rec-rows { background: #F8F9FA; border-radius: 8px; padding: 16px; margin-top: 16px; }
        .rec-row { margin-bottom: 8px; font-size: 13px; color: #555; overflow: hidden; }
        .rec-row .lbl { float: left; }
        .rec-row .val { float: right; }
        .total-row { font-size: 15px; font-weight: bold; color: #181A18; border-top: 1px dashed #ccc; padding-top: 8px; margin-top: 8px; }
        .denda { color: #D32F2F; font-size: 12px; margin-top: 8px; font-style: italic; }
        
        .customer-info { margin-top: 24px; border-top: 1px solid #eee; padding-top: 20px; }
        .customer-info h3 { font-size: 16px; margin-bottom: 16px; margin-top: 0; }
        .customer-row { margin-bottom: 8px; font-size: 13px; overflow: hidden; }
        .clabel { float: left; color: #666; }
        .cval { float: right; font-weight: 600; text-align: right; max-width: 60%; }
        
        .receipt-logo { text-align: center; margin-top: 30px; font-size: 20px; font-weight: 800; letter-spacing: 2px; color: #333; }
        .receipt-logo span { color: #1A1F71; }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="header">
            <h1>PAYMENT CONFIRMED!</h1>
            <div class="order-id">ORDER #{{ $pembayaran->id }}</div>
            <p style="font-size: 13px; color: #666;">Thank you for your order. Here is your receipt.</p>
        </div>

        @foreach($transaksis as $trans)
          @php
            $days = \Carbon\Carbon::parse($trans->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($trans->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $subtotal = ($trans->barang->harga_sewa ?? 0) * $trans->jumlah * $days;
            $jaminan  = round(($trans->barang->harga_sewa ?? 0) * $trans->jumlah / 2);
            $rowTotal = $subtotal + $jaminan;
          @endphp
          <div class="receipt-product">
            <div class="receipt-product-header">
              <span class="item-badge">{{ $trans->jumlah }}</span>
              <div class="rec-product-info">
                <div class="rec-product-name">{{ $trans->barang->nama_barang }}</div>
                <div class="rec-price">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</div>
              </div>
              <span class="paid-badge">PAID</span>
              <div style="clear: both;"></div>
            </div>
            
            <div class="rec-dates">
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Mulai Penyewaan</div>
                <div class="rec-date-val">
                  <span>{{ \Carbon\Carbon::parse($trans->tanggal_sewa)->format('d F Y') }}</span>
                </div>
              </div>
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                <div class="rec-date-val">
                  <span>{{ \Carbon\Carbon::parse($trans->tanggal_kembali_rencana)->format('d F Y') }}</span>
                </div>
              </div>
            </div>
            
            <div class="rec-rows">
              <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $days }} Hari</span><div style="clear: both;"></div></div>
              <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span><div style="clear: both;"></div></div>
              <div class="rec-row"><span class="lbl">Shipping</span><span class="val">-</span><div style="clear: both;"></div></div>
              <div class="rec-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan, 0, ',', '.') }}</span><div style="clear: both;"></div></div>
              <div class="rec-row total-row"><span class="lbl">Total</span><span class="val">Rp {{ number_format($rowTotal, 0, ',', '.') }}</span><div style="clear: both;"></div></div>
              <div class="rec-row denda"><span class="lbl">#Catatan Denda Pengembalian</span><span class="val">Rp 15.000/jam</span><div style="clear: both;"></div></div>
            </div>
          </div>
        @endforeach

        <div class="customer-info">
          <h3>Informasi Pesanan</h3>
          <div class="customer-row">
            <div class="clabel">Nama Customer</div>
            <div class="cval">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : 'Customer' }}</div>
            <div style="clear: both;"></div>
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
            <div style="clear: both;"></div>
          </div>
          <div class="customer-row">
            <div class="clabel">Metode Pembayaran</div>
            <div class="cval">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</div>
            <div style="clear: both;"></div>
          </div>
          <div class="customer-row">
            <div class="clabel">Waktu Pemesanan</div>
            <div class="cval">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d F Y, H:i') . ' WIB' : '-' }}</div>
            <div style="clear: both;"></div>
          </div>
        </div>

        <div class="receipt-logo">SEWA<span>IN</span></div>
    </div>
</body>
</html>
