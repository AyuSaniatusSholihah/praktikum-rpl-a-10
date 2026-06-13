<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Confirmed — SEWAIN</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Lato:wght@400;700&family=Jost:wght@400;500;600&family=Vidaloka&family=Poppins:wght@300;400;500;600;700&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body style="margin:0;padding:0;font-family:'Poppins',Arial,sans-serif;background:#f5f5f5;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f5f5f5; padding:32px 0px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;">

          <!-- HEADER -->
          <tr>
            <td align="center" style="padding:24px 0;border-bottom:1px solid #f0f0f0;">
              <div style="padding: 16px 16px 0px; font-size: 32px; font-weight: 700; font-family: 'Vidaloka', serif; color: #181A18;">SEWA<span style="color: #6A87A1;">IN</span></div>
            </td>
          </tr>

          <!-- CHECK + CONFIRMED -->
          <tr>
            <td align="center" style="padding:12px 24px 12px;">
              <table width="64" height="64" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;margin-bottom:16px;background-color:#6A87A1;border-radius:50%;margin-left:auto;margin-right:auto;">
                <tr>
                  <td align="center" valign="middle">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/checkmark--v1.png" width="32" height="32" alt="✓" style="display:block;margin:0 auto;">
                  </td>
                </tr>
              </table>
              <br>
              <div style="font-size: 24px; font-weight: 700; color: #181A18; margin-bottom: 8px;">PAYMENT CONFIRMED!</div>
              <div style="font-size: 16px; color: #666;">ORDER <strong style="color: #6A87A1;">#{{ $pembayaran->id ?? '-' }}</strong></div>
              <p style="margin-top: 20px; font-size: 14px; color: #666; line-height: 1.6; max-width: 480px; text-align: center;">Thank you for buying from SEWAIN. The system is grateful to you. Please check your e-mail, there will be a payment link that will be sent to your e-mail address according to your agreement.</p>
            </td>
          </tr>

          <tr><td style="height:1px;background:#e8e8e8;"></td></tr>

          <!-- PRODUCT -->
          @foreach($transaksis as $trans)
          @php
            $days     = \Carbon\Carbon::parse($trans->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($trans->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $subtotal = ($trans->barang->harga_sewa ?? 0) * $trans->jumlah * $days;
            $jaminan  = round(($trans->barang->harga_sewa ?? 0) * $trans->jumlah / 2);
            $shipping = 20000;
            $rowTotal = $subtotal + $jaminan + $shipping;
            {{-- Foto: gunakan asset() untuk URL absolut agar bisa tampil di email client --}}
            $fotoUrl  = $trans->barang->foto_barang
                        ? asset('storage/' . $trans->barang->foto_barang)
                        : 'https://placehold.co/90x100?text=Foto';
          @endphp
          <tr>
            <td style="padding:20px 24px;background:#f9f9f9;border-bottom:1px solid #e8e8e8;">

              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="110" valign="top" style="position:relative;">
                    <div style="position:relative;display:inline-block;">
                      <span style="position:absolute;top:-6px;left:-6px;background:#6A87A1;color:#fff;font-size:10px;font-weight:700;width:20px;height:20px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;z-index:1;">{{ $trans->jumlah }}</span>
                      <img src="{{ $fotoUrl }}" alt="{{ $trans->barang->nama_barang }}" width="90" height="100" style="display:block;object-fit:cover;border-radius:4px;border:1px solid #e0e0e0;">
                    </div>
                  </td>
                  <td valign="top" style="padding-left:14px;position:relative;">
                    <p style="font-size:15px;font-weight:700;color:#000;margin:0 0 4px;">{{ $trans->barang->nama_barang }}</p>
                    <p style="font-size:13px;color:#6A87A1;font-weight:600;margin:0 0 10px;">Rp {{ number_format($trans->barang->harga_sewa, 0, ',', '.') }}/hari</p>
                    <span style="position:absolute; top:30px; right: 20px; margin:0; display:inline-block; padding: 4px 12px; background: rgba(106, 135, 161, 0.1); color: #6A87A1; font-weight: 700; font-size: 12px; border-radius: 4px; border: 1px solid #6A87A1;">PAID</span>
                  </td>
                </tr>
              </table>

              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0 16px;">
                <tr>
                  <td width="50%" valign="top" style="padding-right: 8px;">
                    <div style="background: #fff; padding: 12px; border-radius: 8px; border: 1px solid #e8e8e8;">
                      <div style="font-size: 11px; color: #666; margin-bottom: 4px;">Tanggal Mulai Penyewaan</div>
                      <div style="font-size: 13px; font-weight: 600; color: #181A18;">
                        📅 {{ \Carbon\Carbon::parse($trans->tanggal_sewa)->translatedFormat('d F Y') }}
                      </div>
                    </div>
                  </td>
                  <td width="50%" valign="top" style="padding-left: 8px;">
                    <div style="background: #fff; padding: 12px; border-radius: 8px; border: 1px solid #e8e8e8;">
                      <div style="font-size: 11px; color: #666; margin-bottom: 4px;">Tanggal Selesai Penyewaan</div>
                      <div style="font-size: 13px; font-weight: 600; color: #181A18;">
                        📅 {{ \Carbon\Carbon::parse($trans->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                      </div>
                    </div>
                  </td>
                </tr>
              </table>

              <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size:13px;color:#484848; background: #fff; border-radius: 8px; padding: 12px; border: 1px solid #e8e8e8;">
                <tr>
                  <td>Durasi Sewa</td>
                  <td align="right" style="font-weight: 600;">{{ $days }} Hari</td>
                </tr>
                <tr>
                  <td>Subtotal</td>
                  <td align="right" style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Shipping</td>
                  <td align="right" style="font-weight: 600;">Rp {{ number_format($shipping, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Jaminan</td>
                  <td align="right" style="font-weight: 600;">Rp {{ number_format($jaminan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td colspan="2" style="padding: 0;"><div style="height: 1px; background: #e8e8e8; margin: 6px 0;"></div></td>
                </tr>
                <tr>
                  <td style="font-weight:700; color: #181A18; font-size: 14px;">Total</td>
                  <td align="right" style="font-weight:700; color: #6A87A1; font-size: 15px;">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td colspan="2" style="padding: 0;"><div style="height: 1px; background: #e8e8e8; margin: 6px 0;"></div></td>
                </tr>
                <tr>
                  <td style="font-size: 11px; color: #888;">#Catatan Denda Pengembalian</td>
                  <td align="right" style="font-size: 11px; color: #888;">Rp 15.000/jam</td>
                </tr>
              </table>

            </td>
          </tr>
          @endforeach

          <!-- INFORMASI PESANAN -->
          <tr>
            <td style="padding:24px;">
              <h3 style="margin: 0 0 16px; font-size: 16px; color: #181A18; font-weight: 600; border-bottom: 1px solid #e8e8e8; padding-bottom: 12px;">Informasi Customer</h3>
              <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size: 13px;">
                <tr>
                  <td width="35%" style="color: #666;">Nama Customer</td>
                  <td width="65%" style="font-weight: 600; color: #181A18;">{{ $order ? trim($order->first_name . ' ' . $order->last_name) : (auth()->user()->name ?? '-') }}</td>
                </tr>
                <tr>
                  <td style="color: #666;" valign="top">Alamat</td>
                  <td style="font-weight: 600; color: #181A18;">
                    @if(isset($order) && $order->address)
                      {{ $order->address }}{{ ($order->city || $order->kode_pos) ? ', '.$order->city.' '.$order->kode_pos : '' }}
                    @else
                      -
                    @endif
                  </td>
                </tr>
                <tr>
                  <td style="color: #666;">Metode Pengiriman</td>
                  <td style="font-weight: 600; color: #181A18;">
                    {{ isset($order) && $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}
                  </td>
                </tr>
                <tr>
                  <td style="color: #666;">Metode Pembayaran</td>
                  <td style="font-weight: 600; color: #181A18;">{{ $pembayaran->detail_metode ?? $pembayaran->metode ?? '-' }}</td>
                </tr>
                <tr>
                  <td style="color: #666;">Tanggal Pembayaran</td>
                  <td style="font-weight: 600; color: #181A18;">
                    {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('l, d F Y — H:i') . ' WIB' : '-' }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td align="center" style="padding:24px; border-top: 1px solid #e8e8e8;">
              <a href="{{ url('/') }}" style="display: inline-block; padding: 14px 32px; background-color: #6A87A1; color: #fff; text-decoration: none; font-weight: 600; border-radius: 8px; font-size: 14px;">Back to SEWAIN Home</a>
            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td align="center" style="padding:32px 16px; background:#f9f9f9;">
              <div style="font-size: 24px; font-weight: 700; font-family: 'Vidaloka', serif; color: #181A18; margin-bottom: 12px;">SEWA<span style="color: #6A87A1;">IN</span></div>
              <p style="font-size: 13px; color: #666; line-height: 1.6; margin: 0 0 20px;">We help you find<br>and rent what you<br>need easily</p>
              <div style="font-size: 11px; color: #aaa;">Copyright © {{ date('Y') }} Xpro . All Rights Reserved Term of use SEWAIN</div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>