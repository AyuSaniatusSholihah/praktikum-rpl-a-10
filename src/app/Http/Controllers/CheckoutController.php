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
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceiptMail;

class CheckoutController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            // Kalau user sudah login, cek apakah item ada di keranjang
            if (Auth::check()) {
                $cartItem = Keranjang::where('user_id', Auth::id())
                    ->where('barang_id', $id)
                    ->with('barang')
                    ->first();

                if ($cartItem) {
                    $cartItems = collect([$cartItem]);
                } else {
                    $cartItems = $this->makeTempCart($id);
                }
            } else {
                // Guest: langsung buat temp cart dari barang_id
                $cartItems = $this->makeTempCart($id);
            }
        } else {
            // Tanpa id: ambil dari keranjang (hanya untuk user yang login)
            if (!Auth::check()) {
                return redirect()->route('rentals')->with('error', 'Silakan pilih barang terlebih dahulu.');
            }
            $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('rentals')->with('error', 'Keranjang kosong');
        }

        foreach ($cartItems as $item) {
            $barang = $item->barang;
            if (!$barang) {
                return redirect()->route('rentals')->with('error', 'Produk tidak ditemukan.');
            }
            if ($item->jumlah > $barang->stok) {
                return redirect()->route('rentals')->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}.");
            }
        }

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $item->duration_days = $days;
            $harga    = $item->barang->harga_sewa ?? 0;
            $subtotal = $harga * $item->jumlah * $days;
            $jaminan  = (int) round($harga * $item->jumlah / 2);
            $shipping = 20000;
            $cartTotal += $subtotal + $jaminan + $shipping;
        }

        return view('checkout.CheckoutPage', compact('cartItems', 'cartTotal'))->with('barangId', $id);
    }

    public function store(Request $request)
    {
        $isLoggedIn = Auth::check();

        $request->validate([
            'payment_method'  => 'required|string',
            'shipping_method' => 'required|string',
            'first_name'      => $isLoggedIn ? 'nullable|string' : 'required|string|max:100',
            'last_name'       => $isLoggedIn ? 'nullable|string' : 'nullable|string|max:100',
            'email'           => 'required|email',
            'phone'           => 'required|string',
        ]);

        // ---- Ambil cart items ----
        if ($request->filled('single_barang_id')) {
            // Cek keranjang DB dulu (user login)
            if ($isLoggedIn) {
                $cartItems = Keranjang::where('user_id', Auth::id())
                    ->where('barang_id', $request->single_barang_id)
                    ->with('barang')
                    ->get();
            } else {
                $cartItems = collect();
            }

            if ($cartItems->isEmpty()) {
                $barang = Barang::find($request->single_barang_id);
                if (!$barang) {
                    return redirect()->route('rentals')->with('error', 'Produk tidak ditemukan');
                }
                $cartItems = collect([
                    (object)[
                        'barang_id'              => $barang->id,
                        'barang'                 => $barang,
                        'jumlah'                 => 1,
                        'tanggal_sewa'           => now()->toDateString(),
                        'tanggal_kembali_rencana'=> now()->addDay()->toDateString(),
                    ]
                ]);
            }
        } else {
            // Checkout dari keranjang penuh — hanya untuk user login
            if (!$isLoggedIn) {
                return redirect()->route('rentals')->with('error', 'Silakan login untuk checkout dari keranjang.');
            }
            $cartItems = Keranjang::where('user_id', Auth::id())->with('barang')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('rentals')->with('error', 'Keranjang kosong');
        }

        // ---- Cegah owner checkout barangnya sendiri ----
        if ($isLoggedIn) {
            foreach ($cartItems as $item) {
                if ($item->barang && $item->barang->user_id === Auth::id()) {
                    return redirect()->back()->with('error', 'Anda tidak dapat checkout barang milik Anda sendiri.');
                }
            }
        }

        // ---- Cek stok ----
        foreach ($cartItems as $item) {
            $barang = $item->barang;
            if (!$barang || $barang->stok < $item->jumlah) {
                $nama = $barang ? $barang->nama_barang : 'Barang';
                $stok = $barang ? $barang->stok : 0;
                return redirect()->back()->with('error', "Stok barang '{$nama}' tidak mencukupi. Stok tersedia: {$stok}.");
            }
        }

        // ---- Hitung total ----
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $harga    = $item->barang->harga_sewa ?? 0;
            $subtotal = $harga * $item->jumlah * $days;
            $jaminan  = (int) round($harga * $item->jumlah / 2);
            $shipping = 20000;
            $cartTotal += $subtotal + $jaminan + $shipping;
        }

        // ---- Cek dan Kurangi Saldo Pembeli ----
        if ($isLoggedIn) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->saldo < $cartTotal) {
                return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan checkout. Saldo saat ini: Rp ' . number_format($user->saldo, 0, ',', '.'));
            }
            // Kurangi saldo
            $user->saldo -= $cartTotal;
            $user->save();
        }

        // ---- Mapping metode pembayaran ----
        $rawMetode   = $request->payment_method;
        $metode      = 'transfer bank';
        $detailMetode = $rawMetode;

        if ($rawMetode === 'qris') {
            $metode      = 'qris';
            $detailMetode = 'QRIS';
        } elseif ($rawMetode === 'ewallet') {
            $metode      = 'e-wallet';
            $detailMetode = 'E-Wallet';
        } elseif ($rawMetode === 'transfer') {
            $metode      = 'transfer bank';
            $detailMetode = 'Transfer Bank';
        } elseif ($rawMetode === 'credit' || $rawMetode === 'Credit Card') {
            $metode      = 'transfer bank';
            $detailMetode = 'Credit Card';
        }

        // ---- Buat Pembayaran ----
        $pembayaran = Pembayaran::create([
            'metode'       => $metode,
            'detail_metode'=> $detailMetode,
            'tanggal_bayar'=> Carbon::now(),
            'jumlah_bayar' => $cartTotal,
        ]);

        // ---- Nama customer ----
        if ($isLoggedIn) {
            $firstName = Auth::user()->name;
            $lastName  = '';
        } else {
            $firstName = $request->first_name;
            $lastName  = $request->last_name ?? '';
        }

        // ---- Buat Order ----
        $order = Order::create([
            'user_id'         => $isLoggedIn ? Auth::id() : null,
            'first_name'      => $firstName,
            'last_name'       => $lastName,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'shipping_method' => $request->shipping_method,
            'address'         => $request->address,
            'city'            => $request->city,
            'kode_pos'        => $request->kode_pos,
        ]);

        // ---- Activity Log (hanya kalau login) ----
        if ($isLoggedIn) {
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'order_created',
                'description' => 'Order created with total: ' . $cartTotal,
            ]);
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'payment_made',
                'description' => 'Payment for cart total: ' . $cartTotal,
            ]);
        }

        // ---- Buat TransaksiPenyewaan ----
        $transaksiIds = [];
        foreach ($cartItems as $item) {
            $days     = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
            if ($days == 0) $days = 1;
            $subtotal = ($item->barang->harga_sewa ?? 0) * $item->jumlah * $days;

            // Kurangi stok dan update status barang
            $barang = $item->barang;
            if ($barang) {
                $barang->stok -= $item->jumlah;
                if ($barang->stok <= 0) {
                    $barang->status = 'tidak_tersedia';
                }
                $barang->save();

                // Tambah saldo ke pemilik barang
                $owner = $barang->user;
                if ($owner) {
                    $owner->saldo += $subtotal;
                    $owner->save();
                }
            }

            $tanggalSewa = Carbon::parse($item->tanggal_sewa)->startOfDay();
            $status      = $tanggalSewa->greaterThan(Carbon::today()) ? 'upcoming' : 'aktif';

            $trx = TransaksiPenyewaan::create([
                'user_id'                => $isLoggedIn ? Auth::id() : null,
                'barang_id'              => $item->barang_id ?? $item->barang->id,
                'pembayaran_id'          => $pembayaran->id,
                'jumlah'                 => $item->jumlah,
                'tanggal_sewa'           => $item->tanggal_sewa,
                'tanggal_kembali_rencana'=> $item->tanggal_kembali_rencana,
                'waktu_sewa'             => $item->waktu_sewa ?? '08:00:00',
                'waktu_kembali_rencana'  => $item->waktu_kembali_rencana ?? '08:00:00',
                'status'                 => $status,
                'total_harga'            => $subtotal,
            ]);

            $transaksiIds[] = $trx->id;

            // Hapus dari keranjang kalau user login
            if ($item instanceof Keranjang) {
                $item->delete();
            }
        }

        // Simpan pembayaran_id di session supaya halaman konfirmasi bisa ditampilkan ke guest
        session(['last_pembayaran_id' => $pembayaran->id, 'last_order_id' => $order->id]);

        // ---- Kirim Email Receipt ----
        try {
            $transaksis = TransaksiPenyewaan::whereIn('id', $transaksiIds)->with('barang')->get();
            Mail::to($request->email)->queue(new OrderReceiptMail($order, $pembayaran, $transaksis));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send receipt email: " . $e->getMessage());
        }

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil dibuat!');
    }

    /** Buat temporary cart dari satu barang_id */
    private function makeTempCart($id): \Illuminate\Support\Collection
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return collect();
        }
        // Cegah owner checkout barangnya sendiri
        if (Auth::check() && $barang->user_id === Auth::id()) {
            return collect();
        }
        return collect([
            (object)[
                'barang'                 => $barang,
                'jumlah'                 => 1,
                'tanggal_sewa'           => now()->toDateString(),
                'tanggal_kembali_rencana'=> now()->addDay()->toDateString(),
            ]
        ]);
    }
}
