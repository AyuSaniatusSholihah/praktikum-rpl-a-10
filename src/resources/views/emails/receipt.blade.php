<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #1A1F71; margin: 0; }
        .details { margin-bottom: 20px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th, .details td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; }
        .footer { text-align: center; font-size: 0.9em; color: #777; margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SEWAIN Receipt</h1>
            <p>Thank you for your order!</p>
        </div>
        
        <div class="details">
            <p><strong>Order ID:</strong> #{{ $pembayaran->id }}</p>
            <p><strong>Date:</strong> {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d M Y, H:i') : now()->format('d M Y, H:i') }}</p>
            <p><strong>Customer Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
            <p><strong>Shipping Method:</strong> {{ $order->shipping_method == 'cod' ? 'COD (Ambil Sendiri)' : 'Delivery' }}</p>
            @if($order->shipping_method == 'delivery' && $order->address)
                <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }} {{ $order->kode_pos }}</p>
            @endif
            <p><strong>Payment Method:</strong> {{ $pembayaran->detail_metode }}</p>

            <h3>Items Rented</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $trans)
                        @php
                            $days = \Carbon\Carbon::parse($trans->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($trans->tanggal_kembali_rencana));
                            if ($days == 0) $days = 1;
                            $subtotal = ($trans->barang->harga_sewa ?? 0) * $trans->jumlah * $days;
                            $jaminan = round(($trans->barang->harga_sewa ?? 0) * $trans->jumlah / 2);
                            $total = $subtotal + $jaminan;
                        @endphp
                        <tr>
                            <td>{{ $trans->barang->nama_barang }} ({{ $days }} Hari)</td>
                            <td>{{ $trans->jumlah }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <h3 style="text-align: right;">Total Paid: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</h3>
        </div>

        <div class="footer">
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} SEWAIN. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
