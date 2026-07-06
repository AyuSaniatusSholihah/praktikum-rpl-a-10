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
    public function index(Request $request, $id = null)
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
                    $cartItems = $this->makeTempCart($id, $request);
                }
            } else {
                // Guest: langsung buat temp cart dari barang_id
                $cartItems = $this->makeTempCart($id, $request);
            }
        } else {
            // Tanpa id: ambil dari keranjang (hanya untuk user yang login)
            if (!Auth::check()) {
                return redirect()->route('rentals')->with('error', 'Silakan pilih barang terlebih dahulu.');
            }
            $query = Keranjang::where('user_id', Auth::id())->with('barang');
            if ($request->has('items')) {
                $itemIds = explode(',', $request->items);
                $query->whereIn('id', $itemIds);
            }
            $cartItems = $query->get();
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

        $cartTotal = $this->calculateCartTotal($cartItems, 'cod'); // Default COD untuk tampilan keranjang


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
                // Berarti Checkout via "Rent Now" (temp cart)
                $cartItems = $this->makeTempCart($request->single_barang_id, $request);
            }
        } else {
            // Checkout dari keranjang penuh — hanya untuk user login
            if (!$isLoggedIn) {
                return redirect()->route('rentals')->with('error', 'Silakan login untuk checkout dari keranjang.');
            }
            $query = Keranjang::where('user_id', Auth::id())->with('barang');
            if ($request->has('items')) {
                $itemIds = explode(',', $request->items);
                $query->whereIn('id', $itemIds);
            }
            $cartItems = $query->get();
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
        $this->verifyStockAvailability($cartItems);

        // ---- Hitung total ----
        $cartTotal = $this->calculateCartTotal($cartItems, $request->shipping_method);

        // ---- Cek dan Kurangi Saldo Pembeli ----
        if ($isLoggedIn) {
            $this->processUserBalancePayment(Auth::user(), $cartTotal);
        }

        // ---- Mapping metode pembayaran ----
        $paymentDetails = $this->mapPaymentMethod($request->payment_method);

        // ---- Buat Pembayaran ----
        $pembayaran = Pembayaran::create([
            'metode'       => $paymentDetails['metode'],
            'detail_metode'=> $paymentDetails['detail_metode'],
            'tanggal_bayar'=> Carbon::now(),
            'jumlah_bayar' => $cartTotal,
        ]);

        // ---- Nama customer ----
        $firstName = $isLoggedIn ? Auth::user()->name : $request->first_name;
        $lastName  = $isLoggedIn ? '' : ($request->last_name ?? '');

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
            ActivityLog::create(['user_id' => Auth::id(), 'action' => 'order_created', 'description' => 'Order created with total: ' . $cartTotal]);
            ActivityLog::create(['user_id' => Auth::id(), 'action' => 'payment_made', 'description' => 'Payment for cart total: ' . $cartTotal]);
        }

        // ---- Buat TransaksiPenyewaan ----
        $transaksiIds = $this->processCartItemsAndCreateTransactions($cartItems, $pembayaran->id, $isLoggedIn);

        // Simpan pembayaran_id di session supaya halaman konfirmasi bisa ditampilkan ke guest
        session(['last_pembayaran_id' => $pembayaran->id, 'last_order_id' => $order->id]);

        // ---- Kirim Email Receipt ----
        try {
            $transaksis = TransaksiPenyewaan::whereIn('id', $transaksiIds)->with(['barang.user'])->get();
            Mail::to($request->email)->send(new OrderReceiptMail($order, $pembayaran, $transaksis));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send receipt email: " . $e->getMessage());
        }

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil dibuat!');
    }

    /** Buat temporary cart dari satu barang_id */
    private function makeTempCart($id, Request $request): \Illuminate\Support\Collection
    {
        $barang = Barang::find($id);
        if (!$barang || (Auth::check() && $barang->user_id === Auth::id())) {
            return collect();
        }
        return collect([
            (object)[
                'barang'                 => $barang,
                'barang_id'              => $barang->id,
                'jumlah'                 => $request->input('jumlah', 1),
                'tanggal_sewa'           => $request->input('tanggal_sewa', now()->toDateString()),
                'waktu_sewa'             => $request->input('waktu_sewa', '08:00:00'),
                'tanggal_kembali_rencana'=> $request->input('tanggal_kembali_rencana', now()->addDay()->toDateString()),
                'waktu_kembali_rencana'  => $request->input('waktu_kembali_rencana', '08:00:00'),
            ]
        ]);
    }

    private function calculateItemSubtotal($item)
    {
        $days = Carbon::parse($item->tanggal_sewa)->diffInDays(Carbon::parse($item->tanggal_kembali_rencana));
        if ($days == 0) $days = 1;
        $harga = $item->barang->harga_sewa ?? 0;
        $subtotal = $harga * $item->jumlah * $days;
        return ['days' => $days, 'subtotal' => $subtotal];
    }

    private function calculateCartTotal($cartItems, $shippingMethod)
    {
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $calc = $this->calculateItemSubtotal($item);
            $jaminan  = (int) round(($item->barang->harga_sewa ?? 0) * $item->jumlah / 2);
            $shipping = ($shippingMethod === 'delivery') ? 20000 : 0;
            $cartTotal += $calc['subtotal'] + $jaminan + $shipping;
        }
        return $cartTotal;
    }

    private function verifyStockAvailability($cartItems)
    {
        foreach ($cartItems as $item) {
            $barang = $item->barang;
            if (!$barang || $barang->stok < $item->jumlah) {
                $nama = $barang ? $barang->nama_barang : 'Barang';
                $stok = $barang ? $barang->stok : 0;
                throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect()->back()->with('error', "Stok barang '{$nama}' tidak mencukupi. Stok tersedia: {$stok}."));
            }
        }
    }

    private function processUserBalancePayment($user, $cartTotal)
    {
        if ($user->saldo < $cartTotal) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan checkout. Saldo saat ini: Rp ' . number_format($user->saldo, 0, ',', '.')));
        }
        $user->saldo -= $cartTotal;
        $user->save();
    }

    private function mapPaymentMethod($rawMetode)
    {
        $metode = 'transfer bank';
        $detailMetode = $rawMetode;

        if ($rawMetode === 'qris') {
            $metode = 'qris';
            $detailMetode = 'QRIS';
        } elseif ($rawMetode === 'ewallet') {
            $metode = 'e-wallet';
            $detailMetode = 'E-Wallet';
        } elseif ($rawMetode === 'transfer') {
            $detailMetode = 'Transfer Bank';
        } elseif (in_array(strtolower($rawMetode), ['credit', 'credit card'])) {
            $detailMetode = 'Credit Card';
        }

        return ['metode' => $metode, 'detail_metode' => $detailMetode];
    }

    private function processCartItemsAndCreateTransactions($cartItems, $pembayaranId, $isLoggedIn)
    {
        $transaksiIds = [];
        foreach ($cartItems as $item) {
            $calc = $this->calculateItemSubtotal($item);
            $subtotal = $calc['subtotal'];

            $barang = $item->barang;
            if ($barang) {
                $barang->stok -= $item->jumlah;
                if ($barang->stok <= 0) $barang->status = 'tidak_tersedia';
                $barang->save();

                if ($owner = $barang->user) {
                    $owner->saldo += $subtotal;
                    $owner->save();
                }
            }

            $tanggalSewa = Carbon::parse($item->tanggal_sewa)->startOfDay();
            $status = $tanggalSewa->greaterThan(Carbon::today()) ? 'upcoming' : 'aktif';

            $trx = TransaksiPenyewaan::create([
                'user_id'                => $isLoggedIn ? Auth::id() : null,
                'barang_id'              => $item->barang_id ?? $item->barang->id,
                'pembayaran_id'          => $pembayaranId,
                'jumlah'                 => $item->jumlah,
                'tanggal_sewa'           => $item->tanggal_sewa,
                'tanggal_kembali_rencana'=> $item->tanggal_kembali_rencana,
                'waktu_sewa'             => $item->waktu_sewa ?? '08:00:00',
                'waktu_kembali_rencana'  => $item->waktu_kembali_rencana ?? '08:00:00',
                'status'                 => $status,
                'total_harga'            => $subtotal,
            ]);

            $transaksiIds[] = $trx->id;

            if ($item instanceof Keranjang) {
                $item->delete();
            }
        }
        return $transaksiIds;
    }
}
