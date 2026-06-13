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
                    {{-- Inline SVG checkmark, stroke hardcoded white --}}
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5"
                         width="50" height="50" xmlns="http://www.w3.org/2000/svg">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
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
            $rowTotal = $subtotal + $jaminan;
            {{-- Foto: gunakan asset() untuk URL absolut agar bisa tampil di email client --}}
            $fotoUrl  = $trans->barang->foto_barang
                        ? asset('storage/' . $trans->barang->foto_barang)
                        : 'https://placehold.co/90x100?text=Foto';
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
                      {{-- Foto: URL sudah absolut via asset() --}}
                      <img src="{{ $fotoUrl }}"
                           alt="{{ $trans->barang->nama_barang }}"
                           width="90" height="100"
                           style="display:block;object-fit:cover;border-radius:4px;border:1px solid #e0e0e0;">
                    </div>
                  </td>
                  <!-- Name + Price -->
                  <td valign="top" style="padding-left:14px;position:relative;">
                    <p style="font-family:'Volkhov',serif;font-size:13px;font-weight:700;color:#000000;line-height:1.4;margin:0 0 4px;">{{ $trans->barang->nama_barang }}</p>
                    <p style="font-size:11px;color:#6A87A1;font-weight:600;margin:0;">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</p>
                    <span style="color:#2e7d32;font-size:14px;font-weight:900;padding:5px 12px;letter-spacing:0.2em;white-space:nowrap;border:3px solid #2e7d32;border-radius:4px;text-transform:uppercase;font-family:'Volkhov',serif;display:inline-block;position:absolute;top:28px;right:0;">PAID</span>
                  </td>
                </tr>
              </table>

              <!-- Dates: table layout (email-safe, bukan flex/grid) -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:16px 0 12px;">
                <tr>
                  <!-- Tanggal Mulai -->
                  <td width="50%" align="center" valign="top" style="padding:8px 4px;text-align:center;">
                    <div style="font-family:'Lato',sans-serif;font-size:11px;color:#181A18;font-weight:900;margin-bottom:4px;">Tanggal Mulai Penyewaan</div>
                    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                      <tr>
                        <td valign="middle" style="padding-right:4px;">
                          {{-- Kalender SVG: fill hardcoded, JANGAN pakai color: CSS di sini --}}
                          <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                          </svg>
                        </td>
                        <td valign="middle" style="font-family:'Lato',sans-serif;font-size:11px;font-weight:400;color:#181A18;">
                          {{ $trans->tanggal_sewa->format('d F Y') }}
                        </td>
                      </tr>
                    </table>
                  </td>
                  <!-- Tanggal Selesai -->
                  <td width="50%" align="center" valign="top" style="padding:8px 4px;text-align:center;">
                    <div style="font-family:'Lato',sans-serif;font-size:11px;color:#181A18;font-weight:900;margin-bottom:4px;">Tanggal Selesai Penyewaan</div>
                    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                      <tr>
                        <td valign="middle" style="padding-right:4px;">
                          <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                          </svg>
                        </td>
                        <td valign="middle" style="font-family:'Lato',sans-serif;font-size:11px;font-weight:400;color:#181A18;">
                          {{ $trans->tanggal_kembali_rencana->format('d F Y') }}
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Rows: price breakdown -->
              <table width="100%" cellpadding="4" cellspacing="0" border="0" style="margin-top:8px;">
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;">Durasi Sewa</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;font-weight:500;text-align:right;">{{ $days }} Hari</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;">Subtotal</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;font-weight:500;text-align:right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;">Shipping</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;font-weight:500;text-align:right;">-</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;">Jaminan</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;font-weight:500;text-align:right;">Rp {{ number_format($jaminan, 0, ',', '.') }}</td>
                </tr>
                <tr style="border-top:1px solid #e0e0e0;">
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:#484848;padding-top:8px;">Total</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:13px;color:#484848;font-weight:700;text-align:right;padding-top:8px;">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="font-family:'Poppins',sans-serif;font-size:12px;font-style:italic;color:#888;">#Catatan Denda Pengembalian</td>
                  <td style="font-family:'Poppins',sans-serif;font-size:12px;color:#888;font-weight:500;text-align:right;font-style:italic;">Rp 15.000/jam</td>
                </tr>
              </table>

            </td>
          </tr>
          @endforeach

          <!-- ── INFORMASI PESANAN ── -->
          <tr>
            <td style="padding:24px;background:#fff;border-top:1px solid #e8e8e8;">
              <div style="font-family:'Volkhov',serif;font-size:19px;font-weight:700;color:#000000;text-align:center;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #e8e8e8;">Informasi Customer</div>
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="50%" style="padding:6px 8px 6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:12px;">Nama Customer</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:13px;">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : (auth()->user()->name ?? '-') }}</div>
                  </td>
                  <td width="50%" style="padding:6px 0 6px 8px;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:12px;">Metode Pengiriman</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:13px;">
                      {{ isset($order) && $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}
                      @if(isset($order) && $order->shipping_method == 'delivery' && $order->address)
                        — {{ $order->address }}{{ ($order->city || $order->kode_pos) ? ', '.$order->city.' '.$order->kode_pos : '' }}
                      @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding:6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:12px;">Metode Pembayaran</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:13px;">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding:6px 0;vertical-align:top;">
                    <div style="font-family:'Poppins',sans-serif;color:#484848;font-weight:400;margin-bottom:2px;font-size:12px;">Waktu Pemesanan</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;color:#484848;font-size:13px;">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d F Y, H:i').' WIB' : '-' }}</div>
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