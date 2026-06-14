<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Lato:wght@400;700&family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
  <title>Order Receipt - SEWAIN</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f5f5f5;">

  <!-- Wrapper -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f5f5f5;padding:0px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;">

          <!-- ── HEADER: Logo ── -->
          <tr>
            <td align="center" style="padding:24px 0;border-bottom:1px solid #f0f0f0;">
              <div style="font-family:'Vidaloka',serif;font-size:35px;color:#484848;letter-spacing:0.04em;text-align:center;">SEWA<span style="color:#6A87A1;">IN</span></div>
            </td>
          </tr>

          <!-- ── CHECK CIRCLE + CONFIRMED ── -->
          <tr>
            <td align="center" style="padding:24px 12px;">
              {{-- Check circle: using table layout for email client compatibility --}}
              <table cellpadding="0" cellspacing="0" border="0" style="margin:20px auto 12px;">
                <tr>
                  <td width="90" height="90" align="center" valign="middle"
                      style="width:90px;height:90px;border-radius:50%;background:#6A87A1;box-shadow:0 8px 24px rgba(106,135,161,0.4);">
                    @php
                      $ceklisPath = public_path('assets/img/ceklis.png');
                      $ceklisUrl  = file_exists($ceklisPath) && isset($message) ? $message->embed($ceklisPath) : asset('assets/img/ceklis.png');
                    @endphp
                    <img src="{{ $ceklisUrl }}" width="50" height="50" alt="✓" style="display:block;margin:0 auto;">
                  </td>
                </tr>
              </table>

              <div style="font-family:'Volkhov',serif;font-size:30px;font-weight:500;color:#484848;margin:8px 0 0;">PAYMENT CONFIRMED!</div>
              <div style="font-size:16px;color:#888;margin:4px 0 0;">ORDER <strong style="color:#6A87A1;">#{{ $pembayaran->id ?? '-' }}</strong></div>
              <p style="margin:20px 0 0;font-family:'Abhaya Libre',serif;font-weight:600;font-size:15px;color:#818181;line-height:1.8;padding:0 8px;">
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
            $shipping = (isset($order) && $order->shipping_method === 'delivery') ? 20000 : 0;
            $rowTotal = $subtotal + $jaminan + $shipping;
            // Foto: embed file fisik agar tampil di email
            $fotoPath = $trans->barang->foto_barang ? storage_path('app/public/' . $trans->barang->foto_barang) : null;
            if ($fotoPath && file_exists($fotoPath) && isset($message)) {
                $fotoUrl = $message->embed($fotoPath);
            } else {
                // Fallback jika tidak ada atau error
                $fotoUrl = 'https://placehold.co/90x100?text=Foto';
            }
          @endphp

          <tr>
            <td style="padding:20px 24px;background:#f9f9f9;border-bottom:1px solid #e8e8e8;">

              <!-- Product header row -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <!-- Badge + Image -->
                  <td width="110" valign="top" style="position:relative;line-height:0;padding-top:6px;">
                    <div style="position:relative;display:block;width:90px;">
                      <span style="position:absolute;top:-4px;left:-6px;background:#6A87A1;color:#fff;font-size:11px;font-weight:700;width:22px;height:22px;min-width:22px;border-radius:50%;display:inline-block;z-index:2;box-shadow:0 2px 4px rgba(0,0,0,0.2);line-height:22px;padding:0;margin:0;text-align:center;box-sizing:border-box;">{{ $trans->jumlah }}</span>
                      <img src="{{ $fotoUrl }}"
                          alt="{{ $trans->barang->nama_barang }}"
                          width="90" height="100"
                          style="display:block;object-fit:cover;border-radius:4px;border:1px solid #e0e0e0;">
                    </div>
                  </td>
                  <!-- Name + Price -->
                  <td valign="top" style="padding-left:14px;position:relative;padding-top:12px;">
                    <p style="font-family:'Volkhov',serif;font-size:20px;font-weight:700;color:#000000;line-height:1.4;margin:0 0 4px;">{{ $trans->barang->nama_barang }}</p>
                    <p style="font-size:17px;color:#6A87A1;font-weight:600;margin:0;">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</p>
                    <span style="color:#2e7d32;font-size:14px;font-weight:900;padding:5px 12px;letter-spacing:0.2em;white-space:nowrap;border:3px solid #2e7d32;border-radius:4px;text-transform:uppercase;font-family:'Volkhov',serif;display:inline-block;position:absolute;top:38px;right:0;">PAID</span>
                  </td>
                </tr>
              </table>

              <!-- Dates: table layout (email-safe, bukan flex/grid) -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:16px 0 12px;">
                <tr>
                  <!-- Tanggal Mulai -->
                  <td width="50%" align="center" valign="top" style="padding:8px 4px;text-align:center;">
                    <div style="font-family:'Lato',sans-serif;font-size:15px;color:#181A18;font-weight:900;margin-bottom:4px;">Tanggal Mulai Penyewaan</div>
                    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                      @php
                        $kalenderPath = public_path('assets/img/ikonkalender.jpeg');
                        $kalenderUrl  = file_exists($kalenderPath) && isset($message) ? $message->embed($kalenderPath) : asset('assets/img/ikonkalender.jpeg');
                      @endphp
                      <tr>
                        <td valign="middle" style="padding-right:4px;">
                          <img src="{{ $kalenderUrl }}" width="17" height="17" alt="📅" style="display:block;margin:0 auto;">
                        </td>
                        <td valign="middle" style="font-family:'Lato',sans-serif;font-size:15px;font-weight:400;color:#181A18;">
                          {{ $trans->tanggal_sewa->format('d F Y') }} <br> {{ \Carbon\Carbon::parse($trans->waktu_sewa)->format('H:i') }} WIB
                        </td>
                      </tr>
                    </table>
                  </td>
                  <!-- Tanggal Selesai -->
                  <td width="50%" align="center" valign="top" style="padding:8px 4px;text-align:center;">
                    <div style="font-family:'Lato',sans-serif;font-size:15px;color:#181A18;font-weight:900;margin-bottom:4px;">Tanggal Selesai Penyewaan</div>
                    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                      <tr>
                        <td valign="middle" style="padding-right:4px;">
                          <img src="{{ $kalenderUrl }}" width="17" height="17" alt="📅" style="display:block;margin:0 auto;">
                        </td>
                        <td valign="middle" style="font-family:'Lato',sans-serif;font-size:15px;font-weight:400;color:#181A18;">
                          {{ $trans->tanggal_kembali_rencana->format('d F Y') }} <br> {{ \Carbon\Carbon::parse($trans->waktu_kembali_rencana)->format('H:i') }} WIB
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Rows: price breakdown -->
              <table width="100%" cellpadding="4" cellspacing="0" border="0" style="margin-top:8px;">
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font: size 15px;color:#484848;">Durasi Sewa</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;font-weight:500;text-align:right;">{{ $days }} Hari</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;">Subtotal</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;font-weight:500;text-align:right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;">Shipping</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;font-weight:500;text-align:right;">{{ $shipping > 0 ? 'Rp ' . number_format($shipping, 0, ',', '.') : '-' }}</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;">Jaminan</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;font-weight:500;text-align:right;">Rp {{ number_format($jaminan, 0, ',', '.') }}</td>
                </tr>
                <tr style="border-top:1px solid #e0e0e0;">
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:#484848;padding-top:8px;">Total</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:15px;color:#484848;font-weight:700;text-align:right;padding-top:8px;">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:14px;font-style:italic;color:#888;">#Catatan Denda Pengembalian</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:14px;color:#888;font-weight:500;text-align:right;font-style:italic;">Rp {{ number_format($trans->barang->harga_denda_perjam ?? 15000, 0, ',', '.') }}/jam</td>
                </tr>
              </table>

            </td>
          </tr>
          @endforeach

          <!-- ── INFORMASI PESANAN ── -->
          <tr>
            <td style="padding:24px;background:#fff;border-top:1px solid #e8e8e8;">
              <div style="font-family:'Volkhov',serif;font-size:20px;font-weight:700;color:#000000;text-align:center;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #e8e8e8;">Informasi Customer</div>
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="50%" style="padding:6px 8px 6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:15px;">Nama Customer</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:15px;">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : (auth()->user()->name ?? '-') }}</div>
                  </td>
                  <td width="50%" style="padding:6px 0 6px 8px;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:15px;">Metode Pengiriman</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:15px;">
                      {{ isset($order) && $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}
                      @if(isset($order) && $order->shipping_method == 'delivery' && $order->address)
                        — {{ $order->address }}{{ ($order->city || $order->kode_pos) ? ', '.$order->city.' '.$order->kode_pos : '' }}
                      @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding:6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:15px;">Metode Pembayaran</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:15px;">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding:6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:15px;">Waktu Pemesanan</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:15px;">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d F Y, H:i').' WIB' : '-' }}</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ── CTA BUTTON ── -->
          <tr>
            <td align="center" style="padding:24px;">
              <a href="{{ url('/') }}"
                 style="display:block;width:100%;padding:13px;box-sizing:border-box;background:#6A87A1;color:#fff;border-radius:8px;font-family:'Poppins',sans-serif;font-size:15px;font-weight:400;text-decoration:none;text-align:center;box-shadow:0 6px 20px rgba(106,135,161,0.30);">
                Back to SEWAIN Home
              </a>
            </td>
          </tr>

          <!-- ── FOOTER ── -->
          <tr>
            <td align="center" style="padding:16px;border-top:1px solid #f0f0f0;background:#f9f9f9;">
              <div style="font-family:'Vidaloka',serif;font-size:35px;font-weight:400;color:#484848;letter-spacing:0.04em;">SEWA<span style="color:#6A87A1;">IN</span></div>
              <p style="font-size:13px;color:#555;margin-top:8px;line-height:1.6;">We help you find<br>and rent what you<br>need easily</p>
              <div style="width:100%;margin:28px 0 0;padding:16px 24px 0;box-sizing:border-box;border-top:1px solid #ccc;font-size:12px;color:#888;">Copyright © {{ date('Y') }} Xpro . All Rights Reserved Term of use SEWAIN</div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>