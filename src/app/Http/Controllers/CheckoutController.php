<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\Pembayaran;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiPenyewaan;
use App\Models\ActivityLog;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            // Try to find if this item is already in the cart to fetch user's selected dates/quantity
            $cartItem = Keranjang::where('user_id', Auth::id())
                ->where('barang_id', $id)
                ->with('barang')
                ->first();

            if ($cartItem) {
                $cartItems = collect([$cartItem]);
            } else {
                // Single item checkout fallback based on product ID
                $barang = \App\Models\Barang::find($id);
                if (!$barang) {
                    return redirect()->route('rentals')->with('error', 'Produk tidak ditemukan');
                }
                // ---- Prevent owner from checking out own product ----
                if ($barang->user_id === \Illuminate\Support\Facades\Auth::id()) {
                    return redirect()->route('rentals')->with('error', 'Anda tidak dapat checkout barang milik Anda sendiri.');
                }
                // Create a temporary cart item collection
                $cartItems = collect([
                    (object)[
                        'barang' => $barang,
                        'jumlah' => 1,
                        'tanggal_sewa' => now()->toDateString(),
                        'tanggal_kembali_rencana' => now()->addDay()->toDateString(),
                    ]
                ]);
            }
        } else {
            $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }

        foreach ($cartItems as $item) {
            $barang = $item->barang;
            if (!$barang) {
                return redirect()->route('cart')->with('error', 'Produk tidak ditemukan.');
            }
            if ($item->jumlah > $barang->stok) {
                return redirect()->route('cart')->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}. Silakan kurangi kuantitas di keranjang.");
            }
        }

        $cartTotal = 0;
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $item->duration_days = $days;
            $harga   = $item->barang->harga_sewa ?? 0;
            $subtotal = $harga * $item->jumlah * $days;
            $jaminan  = (int) round($harga * $item->jumlah / 2);
            $shipping = 20000; // biaya kirim flat per item (harus sama dengan CheckoutPage.blade.php)
            $cartTotal += $subtotal + $jaminan + $shipping;
        }

        return view('checkout.CheckoutPage', compact('cartItems', 'cartTotal'))->with('barangId', $id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        if ($request->has('single_barang_id') && $request->single_barang_id) {
            $cartItems = Keranjang::where('user_id', Auth::id())
                ->where('barang_id', $request->single_barang_id)
                ->with('barang')
                ->get();
            
            if ($cartItems->isEmpty()) {
                $barang = Barang::find($request->single_barang_id);
                if (!$barang) {
                    return redirect()->route('rentals')->with('error', 'Produk tidak ditemukan');
                }
                $cartItems = collect([
                    (object)[
                        'barang_id' => $barang->id,
                        'barang' => $barang,
                        'jumlah' => 1,
                        'tanggal_sewa' => now()->toDateString(),
                        'tanggal_kembali_rencana' => now()->addDay()->toDateString(),
                    ]
                ]);
            }
        } else {
            $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }

        // ---- Prevent owners from checking out their own products ----
        foreach ($cartItems as $item) {
            if ($item->barang && $item->barang->user_id === Auth::id()) {
                return redirect()->route('cart')
                    ->with('error', 'Anda tidak dapat checkout barang milik Anda sendiri.');
            }
        }

        // ---- Check stock availability for all items before proceeding ----
        foreach ($cartItems as $item) {
            $barang = $item->barang;
            if (!$barang || $barang->stok < $item->jumlah) {
                $nama = $barang ? $barang->nama_barang : 'Barang';
                $stok = $barang ? $barang->stok : 0;
                return redirect()->route('cart')->with('error', "Stok barang '{$nama}' tidak mencukupi. Stok tersedia: {$stok}.");
            }
        }

        $cartTotal = 0;
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $harga   = $item->barang->harga_sewa ?? 0;
            $subtotal = $harga * $item->jumlah * $days;
            $jaminan  = (int) round($harga * $item->jumlah / 2);
            $shipping = 20000; // biaya kirim flat per item (harus sama dengan CheckoutPage.blade.php)
            $cartTotal += $subtotal + $jaminan + $shipping;
        }

        // Map incoming payment method to database enum values: 'transfer bank', 'e-wallet', 'qris'
        $rawMetode = $request->payment_method;
        $metode = 'transfer bank';
        $detailMetode = $rawMetode;

        if ($rawMetode === 'qris') {
            $metode = 'qris';
            $detailMetode = 'QRIS';
        } elseif ($rawMetode === 'ewallet') {
            $metode = 'e-wallet';
            $detailMetode = 'E-Wallet';
        } elseif ($rawMetode === 'transfer') {
            $metode = 'transfer bank';
            $detailMetode = 'Transfer Bank';
        } elseif ($rawMetode === 'credit' || $rawMetode === 'Credit Card') {
            $metode = 'transfer bank';
            $detailMetode = 'Credit Card';
        }

        // Create Pembayaran (including jaminan)
        $pembayaran = Pembayaran::create([
            'metode' => $metode,
            'detail_metode' => $detailMetode,
            'tanggal_bayar' => Carbon::now(),
            'jumlah_bayar' => $cartTotal,
        ]);

        // Create Order record with contact and shipping details
        Order::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shipping_method' => $request->shipping_method,
        ]);

        // Log order creation activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'order_created',
            'description' => 'Order created with total: ' . $cartTotal,
        ]);

        // Log payment activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'payment_made',
            'description' => 'Payment for cart total: ' . $cartTotal,
        ]);

        // Create TransaksiPenyewaan
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $subtotal = ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;

            // Kurangi stok barang dan perbarui status jika habis
            $barang = $item->barang;
            if ($barang) {
                $barang->stok -= $item->jumlah;
                if ($barang->stok <= 0) {
                    $barang->status = 'tidak_tersedia';
                }
                $barang->save();
            }

            TransaksiPenyewaan::create([
                'user_id' => Auth::id(),
                'barang_id' => $item->barang_id ?? $item->barang->id,
                'pembayaran_id' => $pembayaran->id,
                'jumlah' => $item->jumlah,
                'tanggal_sewa' => $item->tanggal_sewa,
                'tanggal_kembali_rencana' => $item->tanggal_kembali_rencana,
                'status' => 'aktif',
                'total_harga' => $subtotal,
            ]);

            // Only delete this item from the cart if it actually exists in the DB
            if ($item instanceof Keranjang) {
                $item->delete();
            }
        }

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil dibuat!');
    }
}
