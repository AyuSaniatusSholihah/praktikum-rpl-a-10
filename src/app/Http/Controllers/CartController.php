<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityLog;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        $cartTotal = 0;
        foreach($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $item->duration_days = $days;
            $cartTotal += ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;
        }
        
        return view('cart.CartPage', compact('cartItems', 'cartTotal'));
    }

    
    public function add(Request $request)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'qty'        => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // ---- Prevent owner from adding own product to cart ----
        $barang = \App\Models\Barang::findOrFail($request->barang_id);
        if ($barang->user_id === \Illuminate\Support\Facades\Auth::id()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Anda tidak dapat menambahkan barang milik Anda sendiri ke keranjang.'], 422);
            }
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menambahkan barang milik Anda sendiri ke keranjang.');
        }

        $item = Keranjang::where('user_id', Auth::id())
                         ->where('barang_id', $request->barang_id)
                         ->first();

        $currentInCart = $item ? $item->jumlah : 0;
        $totalRequested = $currentInCart + $request->qty;

        if ($totalRequested > $barang->stok) {
            $msg = "Jumlah barang di keranjang melebihi stok yang tersedia. Stok tersedia: {$barang->stok}";
            if ($currentInCart > 0) {
                $msg .= " (Anda sudah memiliki {$currentInCart} unit di keranjang).";
            }
            if ($request->wantsJson()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        if ($item) {
            $item->jumlah = $totalRequested;
            $item->tanggal_sewa = $request->start_date;
            $item->tanggal_kembali_rencana = $request->end_date;
            $item->save();
        } else {
            $item = Keranjang::create([
                'user_id'                => Auth::id(),
                'barang_id'              => $request->barang_id,
                'jumlah'                 => $request->qty,
                'tanggal_sewa'           => $request->start_date,
                'tanggal_kembali_rencana'=> $request->end_date,
            ]);
        }

        // Log activity
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'add_to_cart',
            'description' => 'Added barang_id: ' . $request->barang_id . ', qty: ' . $request->qty,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang ditambahkan ke keranjang',
                'cart_item_id' => $item->id
            ]);
        }
        return redirect()->route('cart')->with('success', 'Barang ditambahkan ke keranjang');
    }

    public function destroy($id)
    {
        Keranjang::where('user_id', Auth::id())->where('id', $id)->delete();

        // Log removal from cart
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'remove_from_cart',
            'description' => "Removed cart item ID: $id",
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function updateQuantity(Request $request, $id)
    {
        $item = Keranjang::where('user_id', Auth::id())->with('barang')->where('id', $id)->first();
        if ($item && $request->has('quantity')) {
            $newQty = (int) $request->quantity;
            $stok = $item->barang->stok ?? 0;
            if ($newQty > $stok) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => "Jumlah barang melebihi stok yang tersedia. Stok tersedia: {$stok}",
                        'max' => $stok
                    ], 422);
                }
                return redirect()->back()->with('error', "Jumlah barang melebihi stok yang tersedia. Stok tersedia: {$stok}");
            }
            $item->jumlah = $newQty;
            $item->save();
        }
        
        if ($request->wantsJson()) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $subtotal = ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;
            return response()->json(['success' => true, 'subtotal' => $subtotal]);
        }
        return redirect()->back();
    }
}
