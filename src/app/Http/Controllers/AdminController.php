<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembayaran;
use App\Models\TransaksiPenyewaan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            'total_user'  => User::count(),
            'total_owner' => $ownerIds->count(),
            'total_rent'  => TransaksiPenyewaan::count(),
        ];

        $walletByMethod = $this->totalPerMetode();

        $usersPreview = User::withCount('barangs')->latest()->take(3)->get();
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

        $totalSaldoUser  = (float) User::whereNotIn('id', $ownerIds)->sum('saldo');
        $totalSaldoOwner = (float) User::whereIn('id', $ownerIds)->sum('saldo');

        $walletByMethod = $this->totalPerMetode();

        $transaksiTerbaru = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran'])
            ->latest()->take(10)->get();

        return view('admin.financialWalletPage', compact(
            'totalSaldoUser', 'totalSaldoOwner', 'walletByMethod', 'transaksiTerbaru'
        ));
    }

    public function users()
    {
        $this->ensureAdmin();

        $users = User::withCount('barangs')->latest()->get();

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

        return view('admin.userDetailPage', compact('user'));
    }

    public function items()
    {
        $this->ensureAdmin();

        $items = Barang::with(['user', 'kategori'])->latest()->get();

        return view('admin.dataItemPage', compact('items'));
    }

    public function itemDetail($id)
    {
        $this->ensureAdmin();

        $item = Barang::with(['user', 'kategori', 'reviews.user'])->findOrFail($id);

        return view('admin.itemDetailPage', compact('item'));
    }

    public function transactions()
    {
        $this->ensureAdmin();

        $transaksis = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran'])
            ->latest()->get();

        return view('admin.dataTransactions', compact('transaksis'));
    }

    public function transactionDetail($id)
    {
        $this->ensureAdmin();

        $transaksi = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran', 'review'])
            ->findOrFail($id);

        return view('admin.transactionDetailPage', compact('transaksi'));
    }
}
