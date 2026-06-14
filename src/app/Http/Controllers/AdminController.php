<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembayaran;
use App\Models\TransaksiPenyewaan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Pastikan hanya admin yang boleh mengakses. Abort 403 jika bukan.
     */
    private function ensureAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
        }
    }

    /**
     * Total pembayaran dikelompokkan per metode (transfer bank, e-wallet, qris).
     *
     * @return array<string, float>
     */
    private function totalPerMetode(): array
    {
        $totals = Pembayaran::selectRaw('metode, SUM(jumlah_bayar) as total')
            ->groupBy('metode')
            ->pluck('total', 'metode');

        return [
            'transfer bank' => (float) ($totals['transfer bank'] ?? 0),
            'e-wallet'      => (float) ($totals['e-wallet'] ?? 0),
            'qris'          => (float) ($totals['qris'] ?? 0),
        ];
    }

    /**
     * ID user yang merupakan owner (punya minimal 1 barang).
     *
     * @return \Illuminate\Support\Collection<int, int>
     */
    private function ownerIds()
    {
        return Barang::whereNotNull('user_id')->distinct()->pluck('user_id');
    }

    public function dashboard()
    {
        $this->ensureAdmin();

        $ownerIds = $this->ownerIds();

        $stats = [
            'total_user'  => User::where('role', 'user')->count(),
            'total_owner' => $ownerIds->count(),
            'total_rent'  => TransaksiPenyewaan::count(),
        ];

        $walletByMethod = $this->totalPerMetode();

        $usersPreview = User::where('role', 'user')->withCount('barangs')->latest()->take(3)->get();
        $itemsPreview = Barang::with(['user', 'kategori'])->latest()->take(5)->get();
        $transaksiPreview = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran'])
            ->latest()->take(5)->get();

        return view('admin.dashboardPage', compact(
            'stats', 'walletByMethod', 'usersPreview', 'itemsPreview', 'transaksiPreview'
        ));
    }

    public function financialWallet()
    {
        $this->ensureAdmin();

        $ownerIds = $this->ownerIds();

        // Total Saldo User = total semua transaksi penyewaan (pengeluaran penyewa)
        $totalSaldoUser  = (float) TransaksiPenyewaan::sum('total_harga');
        // Total Saldo Owner = total pemasukan owner (transaksi barang-barang milik owner)
        $totalSaldoOwner = (float) TransaksiPenyewaan::join('barangs', 'transaksi_penyewaans.barang_id', '=', 'barangs.id')
            ->whereIn('barangs.user_id', $ownerIds)
            ->sum('transaksi_penyewaans.total_harga');

        $walletByMethod = $this->totalPerMetode();

        $transaksiTerbaru = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran'])
            ->latest()->take(5)->get();

        return view('admin.financialWalletPage', compact(
            'totalSaldoUser', 'totalSaldoOwner', 'walletByMethod', 'transaksiTerbaru'
        ));
    }

    public function users(Request $request)
    {
        $this->ensureAdmin();

        $query = User::where('role', 'user')->withCount('barangs')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('admin.dataUserPage', compact('users'));
    }

    public function userDetail($id)
    {
        $this->ensureAdmin();

        $user = User::withCount('barangs')
            ->with([
                'barangs.kategori',
                'barangs.reviews',
                'transaksiPenyewaan.barang',
                'transaksiPenyewaan.pembayaran',
            ])
            ->findOrFail($id);

        $walletTransactions = TransaksiPenyewaan::where(function($q) use ($id) {
            $q->where('user_id', $id)
              ->orWhereHas('barang', function($qb) use ($id) {
                  $qb->where('user_id', $id);
              });
        })->with(['barang.user', 'pembayaran'])->latest()->get();

        return view('admin.userDetailPage', compact('user', 'walletTransactions'));
    }

    public function items(Request $request)
    {
        $this->ensureAdmin();

        $query = Barang::with(['user', 'kategori'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('kategori', function($qu) use ($search) {
                      $qu->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $items = $query->get();

        return view('admin.dataItemPage', compact('items'));
    }

    public function itemDetail($id)
    {
        $this->ensureAdmin();

        $item = Barang::with(['user', 'kategori', 'reviews.user'])->findOrFail($id);

        return view('admin.itemDetailPage', compact('item'));
    }

    public function deleteItem($id)
    {
        $this->ensureAdmin();
        $item = Barang::findOrFail($id);
        $item->delete();
        
        return redirect()->route('admin.items')->with('success', 'Barang berhasil dihapus.');
    }

    public function transactions(Request $request)
    {
        $this->ensureAdmin();

        $query = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('barang', function($qu) use ($search) {
                      $qu->where('nama_barang', 'like', "%{$search}%")
                        ->orWhereHas('user', function($qou) use ($search) {
                            $qou->where('name', 'like', "%{$search}%");
                        });
                  })
                  ->orWhereHas('pembayaran', function($qu) use ($search) {
                      $qu->where('metode', 'like', "%{$search}%");
                  });
            });
        }

        $transaksis = $query->get();

        return view('admin.dataTransactions', compact('transaksis'));
    }

    public function transactionDetail($id)
    {
        $this->ensureAdmin();

        $transaksi = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran', 'review'])
            ->findOrFail($id);

        return view('admin.transactionDetailPage', compact('transaksi'));
    }

    /**
     * Toggle BAN / UNBAN untuk user.
     * User yang di-ban: sesi aktifnya tidak bisa melakukan transaksi,
     * dan pada login berikutnya akan ditolak oleh LoginController.
     */
    public function toggleBan($id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat mem-ban admin.');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        // Batalkan semua session user yang di-ban
        if ($user->is_banned) {
            // Invalidate semua session milik user ini
            \Illuminate\Support\Facades\DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }

        $msg = $user->is_banned
            ? "User {$user->name} berhasil di-BAN."
            : "User {$user->name} berhasil di-UNBAN.";

        return redirect()->route('admin.users.detail', $id)->with('success', $msg);
    }
}
