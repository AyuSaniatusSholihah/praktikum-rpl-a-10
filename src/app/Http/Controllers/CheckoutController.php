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
            // Single item checkout based on product ID
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
        } else {
            $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        }
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }

        $cartTotal = 0;
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $item->duration_days = $days;
            $harga   = $item->barang->harga_sewa ?? 0;
            $subtotal = $harga * $item->jumlah * $days;
            $jaminan  = (int) round($harga * $item->jumlah / 2);
            $cartTotal += $subtotal + $jaminan;
        }

        return view('checkout.CheckoutPage', compact('cartItems', 'cartTotal'));
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

        $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
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

        $cartTotal = 0;
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $cartTotal += ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;
        }

        // Create Pembayaran
        $pembayaran = Pembayaran::create([
            'metode' => 'Transfer',
            'detail_metode' => $request->payment_method,
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

            TransaksiPenyewaan::create([
                'user_id' => Auth::id(),
                'barang_id' => $item->barang_id,
                'pembayaran_id' => $pembayaran->id,
                'jumlah' => $item->jumlah,
                'tanggal_sewa' => $item->tanggal_sewa,
                'tanggal_kembali_rencana' => $item->tanggal_kembali_rencana,
                'status' => 'diproses',
                'total_harga' => $subtotal,
            ]);
        }

        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil dibuat!');
    }
}
