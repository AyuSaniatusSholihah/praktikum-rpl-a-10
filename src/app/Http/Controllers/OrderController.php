<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenyewaan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function confirmation()
    {
        // Get the latest transaction of the user to find the pembayaran_id
        $lastTrans = TransaksiPenyewaan::where('user_id', Auth::id())->latest()->first();
        if (!$lastTrans) {
            return redirect()->route('home');
        }

        $transaksis = TransaksiPenyewaan::where('pembayaran_id', $lastTrans->pembayaran_id)->with('barang')->get();
        $pembayaran = $lastTrans->pembayaran;

        return view('checkout.ConfirmPage', compact('transaksis', 'pembayaran'));
    }
}
