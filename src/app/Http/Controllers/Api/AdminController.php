<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;

class AdminController extends Controller
{
    /**
     * Helper to verify if the authenticated user is an admin.
     */
    private function verifyAdmin(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Halaman ini hanya untuk Admin.'
            ], 403);
        }
        return null;
    }

    /**
     * Get Dashboard Summary data.
     */
    public function dashboard(Request $request)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $totalUsers = User::where('role', 'user')->count();
        $totalBannedUsers = User::where('role', 'user')->where('is_banned', true)->count();
        $totalItems = Barang::count();
        $totalTransactions = TransaksiPenyewaan::count();
        $totalFinancialWallet = (float) Pembayaran::sum('jumlah_bayar');

        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => [
                    'total_users' => $totalUsers,
                    'total_banned_users' => $totalBannedUsers,
                    'total_items' => $totalItems,
                    'total_transactions' => $totalTransactions,
                    'total_financial_wallet' => $totalFinancialWallet,
                ]
            ]
        ], 200);
    }

    /**
     * Tab Users: Get all users list.
     */
    public function listUsers(Request $request)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $users = User::where('role', 'user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    /**
     * Tab Items: Get all items list.
     */
    public function listItems(Request $request)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $items = Barang::with(['user', 'kategori'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $items
        ], 200);
    }

    /**
     * Tab Transactions: Get all transactions list.
     */
    public function listTransactions(Request $request)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $transactions = TransaksiPenyewaan::with(['user', 'barang', 'pembayaran'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    /**
     * Tab Financial Wallet: Get all financial/payment list.
     */
    public function listPayments(Request $request)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $payments = Pembayaran::latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $payments
        ], 200);
    }

    /**
     * User Detail.
     */
    public function userDetail(Request $request, $id)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $user = User::with(['barangs', 'transaksiPenyewaan'])->find($id);

        if (!$user || $user->role === 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * Item Detail.
     */
    public function itemDetail(Request $request, $id)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $item = Barang::with(['user', 'kategori', 'reviews.user'])->find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ], 200);
    }

    /**
     * Transaction Detail.
     */
    public function transactionDetail(Request $request, $id)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $transaction = TransaksiPenyewaan::with(['user', 'barang.user', 'pembayaran', 'review'])->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }

    /**
     * Finance / Payment Detail.
     */
    public function paymentDetail(Request $request, $id)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $payment = Pembayaran::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pembayaran tidak ditemukan.'
            ], 404);
        }

        // Get related transactions
        $transactions = TransaksiPenyewaan::where('pembayaran_id', $id)->with(['user', 'barang'])->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'payment' => $payment,
                'transactions' => $transactions
            ]
        ], 200);
    }

    /**
     * Ban User Action.
     */
    public function toggleBanUser(Request $request, $id)
    {
        if ($denied = $this->verifyAdmin($request)) {
            return $denied;
        }

        $user = User::find($id);

        if (!$user || $user->role === 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan atau tidak dapat di-ban.'
            ], 404);
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        $statusMessage = $user->is_banned ? 'User berhasil di-ban.' : 'Ban user berhasil dicabut.';

        return response()->json([
            'status' => 'success',
            'message' => $statusMessage,
            'data' => $user
        ], 200);
    }
}
