<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenyewaan;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function confirmation()
    {
        // Coba ambil berdasarkan pembayaran_id yang disimpan di session (untuk guest & login)
        $pembayaranId = session('last_pembayaran_id');
        $orderId      = session('last_order_id');

        if ($pembayaranId) {
            $transaksis = TransaksiPenyewaan::where('pembayaran_id', $pembayaranId)
                ->with('barang')
                ->get();
            $pembayaran = $transaksis->first()?->pembayaran;
            $order      = $orderId ? Order::find($orderId) : null;
        } elseif (Auth::check()) {
            // Fallback untuk user login yang belum punya session (kasus lama)
            $lastTrans = TransaksiPenyewaan::where('user_id', Auth::id())->latest()->first();
            if (!$lastTrans) {
                return redirect()->route('home');
            }
            $transaksis = TransaksiPenyewaan::where('pembayaran_id', $lastTrans->pembayaran_id)
                ->with('barang')
                ->get();
            $pembayaran = $lastTrans->pembayaran;
            $order      = Order::where('user_id', Auth::id())->latest()->first();
        } else {
            return redirect()->route('home');
        }

        if (!$pembayaran || $transaksis->isEmpty()) {
            return redirect()->route('home');
        }

        return view('checkout.ConfirmPage', compact('transaksis', 'pembayaran', 'order'));
    }
}
