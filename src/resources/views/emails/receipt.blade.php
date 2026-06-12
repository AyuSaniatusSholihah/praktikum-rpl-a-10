<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Receipt - SEWAIN</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f5f5f5;">

  <!-- Wrapper -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f5f5f5;padding:32px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;">

          <!-- ── HEADER: Logo ── -->
          <tr>
            <td align="center" style="padding:24px 0 16px;border-bottom:1px solid #f0f0f0;">
              <span style="font-size:32px;font-weight:400;color:#484848;letter-spacing:0.04em;">SEWA<span style="color:#6A87A1;">IN</span></span>
            </td>
          </tr>

          <!-- ── CHECK CIRCLE + CONFIRMED ── -->
          <tr>
            <td align="center" style="padding:36px 24px 20px;">
              <!-- Circle -->
              <div style="width:80px;height:80px;border-radius:50%;background:#6A87A1;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" style="width:80px;height:80px;" arcsize="50%" fillcolor="#6A87A1" strokecolor="#6A87A1"></v:roundrect><![endif]-->
                <img src="https://img.icons8.com/ios/50/ffffff/checkmark--v1.png" width="40" height="40" alt="✓" style="display:block;">
              </div>
              <br>
              <span style="font-size:26px;font-weight:700;color:#484848;display:block;margin-bottom:6px;">PAYMENT CONFIRMED!</span>
              <span style="font-size:15px;color:#888888;">ORDER <strong style="color:#6A87A1;">#{{ $pembayaran->id ?? '-' }}</strong></span>
              <p style="font-size:13px;color:#818181;line-height:1.8;margin:20px auto 0;max-width:420px;">
                Thank you for buying Goodfeel. The system is grateful to you. Please check your e-mail, there will be a payment link that will be sent to your e-mail address according to your agreement.
              </p>
            </td>
          </tr>

          <!-- ── DIVIDER ── -->
          <tr><td style="height:1px;background:#e8e8e8;"></td></tr>

          <!-- ── PRODUCT(S) ── -->
          @foreach($transaksis as $trans)
          @php
            $days     = $trans->tanggal_sewa->diffInDays($trans->tanggal_kembali_rencana);
            if ($days == 0) $days = 1;
            $subtotal = ($trans->barang->harga_sewa ?? 0) * $trans->jumlah * $days;
            $jaminan  = round(($trans->barang->harga_sewa ?? 0) * $trans->jumlah / 2);
            $rowTotal = $subtotal + $jaminan;
          @endphp

          <tr>
            <td style="padding:20px 24px;background:#f9f9f9;border-bottom:1px solid #e8e8e8;">

              <!-- Product header row -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <!-- Badge + Image -->
                  <td width="110" valign="top" style="position:relative;">
                    <div style="position:relative;display:inline-block;">
                      <span style="position:absolute;top:-6px;left:-6px;background:#6A87A1;color:#fff;font-size:10px;font-weight:700;width:20px;height:20px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;z-index:1;">{{ $trans->jumlah }}</span>
                      <img src="{{ $trans->barang->foto_barang ? url('storage/'.$trans->barang->foto_barang) : 'https://placehold.co/90x100?text=Foto' }}"
                           alt="{{ $trans->barang->nama_barang }}"
                           width="90" height="100"
                           style="display:block;object-fit:cover;border-radius:4px;border:1px solid #e0e0e0;">
                    </div>
                  </td>
                  <!-- Name + Price -->
                  <td valign="top" style="padding-left:14px;">
                    <p style="font-size:13px;font-weight:700;color:#000;margin:0 0 4px;">{{ $trans->barang->nama_barang }}</p>
                    <p style="font-size:11px;color:#6A87A1;font-weight:600;margin:0 0 10px;">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</p>
                    <!-- PAID badge -->
                    <span style="display:inline-block;color:#2e7d32;font-size:13px;font-weight:900;padding:5px 12px;border:3px solid #2e7d32;border-radius:4px;letter-spacing:0.15em;opacity:0.75;transform:rotate(-12deg);font-family:Georgia,serif;">PAID</span>
                  </td>
                </tr>
              </table>

              <!-- Dates -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:16px 0 12px;">
                <tr>
                  <td width="50%" align="center" style="padding:8px;">
                    <p style="font-size:11px;font-weight:900;color:#181A18;margin:0 0 4px;">📅 Tanggal Mulai Penyewaan</p>
                    <p style="font-size:11px;color:#181A18;margin:0;">{{ $trans->tanggal_sewa->format('d F Y') }}</p>
                  </td>
                  <td width="50%" align="center" style="padding:8px;">
                    <p style="font-size:11px;font-weight:900;color:#181A18;margin:0 0 4px;">📅 Tanggal Selesai Penyewaan</p>
                    <p style="font-size:11px;color:#181A18;margin:0;">{{ $trans->tanggal_kembali_rencana->format('d F Y') }}</p>
                  </td>
                </tr>
              </table>

              <!-- Rows -->
              <table width="100%" cellpadding="4" cellspacing="0" border="0" style="font-size:11px;color:#484848;">
                <tr>
                  <td>Durasi Sewa</td>
                  <td align="right" style="font-weight:500;">{{ $days }} Hari</td>
                </tr>
                <tr>
                  <td>Subtotal</td>
                  <td align="right" style="font-weight:500;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Shipping</td>
                  <td align="right" style="font-weight:500;">-</td>
                </tr>
                <tr>
                  <td>Jaminan</td>
                  <td align="right" style="font-weight:500;">Rp {{ number_format($jaminan, 0, ',', '.') }}</td>
                </tr>
                <tr style="border-top:1px solid #e0e0e0;">
                  <td style="padding-top:8px;font-weight:700;font-size:12px;">Total</td>
                  <td align="right" style="padding-top:8px;font-weight:700;font-size:12px;">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="font-style:italic;color:#484848;">#Catatan Denda Pengembalian</td>
                  <td align="right" style="font-style:italic;color:#484848;">Rp 15.000/jam</td>
                </tr>
              </table>

            </td>
          </tr>
          @endforeach

          <!-- ── INFORMASI PESANAN ── -->
          <tr>
            <td style="padding:20px 24px;background:#ffffff;border-top:1px solid #e8e8e8;">
              <p style="font-size:17px;font-weight:700;color:#000;text-align:center;margin:0 0 14px;padding-bottom:10px;border-bottom:1px solid #e8e8e8;">Informasi Pesanan</p>
              <table width="100%" cellpadding="6" cellspacing="0" border="0">
                <tr>
                  <td width="50%" valign="top">
                    <p style="font-size:11px;color:#484848;margin:0 0 2px;">Nama Customer</p>
                    <p style="font-size:12px;font-weight:600;color:#484848;margin:0;">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : (auth()->user()->name ?? '-') }}</p>
                  </td>
                  <td width="50%" valign="top">
                    <p style="font-size:11px;color:#484848;margin:0 0 2px;">Metode Pengiriman</p>
                    <p style="font-size:12px;font-weight:600;color:#484848;margin:0;">
                      {{ isset($order) && $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}
                      @if(isset($order) && $order->shipping_method == 'delivery' && $order->address)
                        — {{ $order->address }}{{ ($order->city || $order->kode_pos) ? ', '.$order->city.' '.$order->kode_pos : '' }}
                      @endif
                    </p>
                  </td>
                </tr>
                <tr>
                  <td width="50%" valign="top">
                    <p style="font-size:11px;color:#484848;margin:0 0 2px;">Metode Pembayaran</p>
                    <p style="font-size:12px;font-weight:600;color:#484848;margin:0;">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</p>
                  </td>
                  <td width="50%" valign="top">
                    <p style="font-size:11px;color:#484848;margin:0 0 2px;">Waktu Pemesanan</p>
                    <p style="font-size:12px;font-weight:600;color:#484848;margin:0;">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d F Y, H:i').' WIB' : '-' }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ── CTA BUTTON ── -->
          <tr>
            <td align="center" style="padding:24px;">
              <a href="{{ url('/') }}"
                 style="display:inline-block;padding:13px 40px;background:#6A87A1;color:#ffffff;text-decoration:none;border-radius:8px;font-size:14px;font-weight:500;letter-spacing:0.02em;box-shadow:0 6px 20px rgba(106,135,161,0.30);">
                Back to SEWAIN Home
              </a>
            </td>
          </tr>

          <!-- ── FOOTER ── -->
          <tr>
            <td align="center" style="padding:16px;border-top:1px solid #f0f0f0;background:#f9f9f9;">
              <span style="font-size:28px;font-weight:400;color:#484848;letter-spacing:0.04em;">SEWA<span style="color:#6A87A1;">IN</span></span>
              <p style="font-size:11px;color:#aaaaaa;margin:8px 0 0;">© {{ date('Y') }} SEWAIN. All rights reserved.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>