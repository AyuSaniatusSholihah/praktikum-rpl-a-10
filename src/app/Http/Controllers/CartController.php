<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityLog;

class CartController extends Controller
{
    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    /**
     * [Extract Method] Hitung durasi sewa dalam hari (minimal 1).
     * Menghilangkan duplikasi logika Carbon di index() & updateQuantity().
     */
    private function hitungDurasiHari(string $tanggalMulai, string $tanggalSelesai): int
    {
        $days = Carbon::parse($tanggalMulai)->diffInDays(Carbon::parse($tanggalSelesai));
        return max(1, (int) $days);
    }

    /**
     * [Extract Method] Validasi stok saat menambah ke keranjang.
     * Mengembalikan pesan error, atau null jika stok mencukupi.
     */
    private function pesanStokKurang(Barang $barang, int $totalDiminta, int $sudahDiKeranjang): ?string
    {
        if ($totalDiminta <= $barang->stok) {
            return null;
        }

        $pesan = "Jumlah barang di keranjang melebihi stok yang tersedia. Stok tersedia: {$barang->stok}";
        if ($sudahDiKeranjang > 0) {
            $pesan .= " (Anda sudah memiliki {$sudahDiKeranjang} unit di keranjang).";
        }
        return $pesan;
    }

    /**
     * [Extract Method] Simpan log aktivitas ke tabel activity_logs.
     */
    private function catatAktivitas(string $aksi, string $deskripsi): void
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => $aksi,
            'description' => $deskripsi,
        ]);
    }

    // =========================================================
    // PUBLIC ACTIONS
    // =========================================================

    public function index()
    {
        $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        $cartTotal = 0;

        foreach ($cartItems as $item) {
            $days                = $this->hitungDurasiHari($item->tanggal_sewa, $item->tanggal_kembali_rencana);
            $item->duration_days = $days;
            $cartTotal          += ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;
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
            'start_time' => 'nullable|string',
            'end_time'   => 'nullable|string',
        ]);

        // Cegah owner menambahkan barang miliknya sendiri ke keranjang
        $barang = Barang::findOrFail($request->barang_id);
        if ($barang->user_id === Auth::id()) {
            $pesanError = 'Anda tidak dapat menambahkan barang milik Anda sendiri ke keranjang.';
            if ($request->wantsJson()) {
                return response()->json(['error' => $pesanError], 422);
            }
            return redirect()->back()->with('error', $pesanError);
        }

        $item           = Keranjang::where('user_id', Auth::id())
                                   ->where('barang_id', $request->barang_id)
                                   ->first();
        $sudahDiKeranjang = $item ? $item->jumlah : 0;
        $totalDiminta     = $sudahDiKeranjang + $request->qty;

        // [Simplify Conditional] Validasi stok dipindah ke helper
        $pesanStok = $this->pesanStokKurang($barang, $totalDiminta, $sudahDiKeranjang);
        if ($pesanStok) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $pesanStok], 422);
            }
            return redirect()->back()->with('error', $pesanStok);
        }

        $waktuSewa    = $request->start_time ?? '08:00:00';
        $waktuKembali = $request->end_time   ?? '08:00:00';

        if ($item) {
            $item->jumlah                  = $totalDiminta;
            $item->tanggal_sewa            = $request->start_date;
            $item->tanggal_kembali_rencana = $request->end_date;
            $item->waktu_sewa              = $waktuSewa;
            $item->waktu_kembali_rencana   = $waktuKembali;
            $item->save();
        } else {
            $item = Keranjang::create([
                'user_id'                 => Auth::id(),
                'barang_id'               => $request->barang_id,
                'jumlah'                  => $request->qty,
                'tanggal_sewa'            => $request->start_date,
                'tanggal_kembali_rencana' => $request->end_date,
                'waktu_sewa'              => $waktuSewa,
                'waktu_kembali_rencana'   => $waktuKembali,
            ]);
        }

        $this->catatAktivitas(
            'add_to_cart',
            'Added barang_id: ' . $request->barang_id . ', qty: ' . $request->qty
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'message'      => 'Barang ditambahkan ke keranjang',
                'cart_item_id' => $item->id,
            ]);
        }
        return redirect()->route('cart')->with('success', 'Barang ditambahkan ke keranjang');
    }

    public function destroy($id)
    {
        Keranjang::where('user_id', Auth::id())->where('id', $id)->delete();

        $this->catatAktivitas('remove_from_cart', "Removed cart item ID: $id");

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function updateQuantity(Request $request, $id)
    {
        $item = Keranjang::where('user_id', Auth::id())->with('barang')->where('id', $id)->first();

        if (!$item) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Item keranjang tidak ditemukan.'], 404);
            }
            return redirect()->route('cart')->with('error', 'Item keranjang tidak ditemukan.');
        }

        if ($request->has('quantity')) {
            $jumlahBaru = (int) $request->quantity;
            $stok       = $item->barang->stok ?? 0;

            if ($jumlahBaru > $stok) {
                $pesanError = "Jumlah barang melebihi stok yang tersedia. Stok tersedia: {$stok}";
                if ($request->wantsJson()) {
                    return response()->json(['error' => $pesanError, 'max' => $stok], 422);
                }
                return redirect()->back()->with('error', $pesanError);
            }

            $item->jumlah = $jumlahBaru;
            $item->save();
        }

        if ($request->wantsJson()) {
            $days     = $this->hitungDurasiHari($item->tanggal_sewa, $item->tanggal_kembali_rencana);
            $subtotal = ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;
            return response()->json(['success' => true, 'subtotal' => $subtotal]);
        }
        return redirect()->back();
    }
}
