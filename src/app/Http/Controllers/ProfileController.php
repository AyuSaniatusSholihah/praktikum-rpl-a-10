<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\TransaksiPenyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /** Status penyewaan yang dianggap sedang berjalan / belum selesai. */
    private const STATUS_AKTIF = ['upcoming', 'aktif', 'tunggu verifikasi pengembalian'];

    // ===== HALAMAN PROFILE MENU =====
    public function index()
    {
        $user = Auth::user();

        $katalogCount = $user->barangs()->count();
        $rentalCount  = $user->transaksiPenyewaan()->count();
        $recentRentals = $user->transaksiPenyewaan()
            ->with('barang')
            ->latest()
            ->take(2)
            ->get();

        return view('profile.ProfileMenuPage', compact('user', 'katalogCount', 'rentalCount', 'recentRentals'));
    }

    // ===== SIMPAN PERUBAHAN PROFIL (email TIDAK bisa diubah) =====
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'username'     => 'nullable|string|max:100|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:255',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password'     => 'nullable|string|min:8|confirmed',
        ], [
            'foto_profil.image'  => 'File harus berupa gambar (jpeg, png, jpg, webp).',
            'foto_profil.max'    => 'Ukuran foto maksimal 2 MB.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Catatan: 'email' sengaja TIDAK divalidasi/diupdate -> email terkunci.
        $data = [
            'name'         => $validated['name'],
            'username'     => $validated['username'] ?? $user->username,
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
            'alamat'       => $validated['alamat'] ?? $user->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // ===== MY RENTALS (sebagai penyewa) =====
    public function rentals()
    {
        $user = Auth::user();

        $aktif = $user->transaksiPenyewaan()
            ->with('barang')
            ->whereIn('status', self::STATUS_AKTIF)
            ->latest()
            ->get();

        $history = $user->transaksiPenyewaan()
            ->with('barang')
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('profile.MyRentalsPage', compact('user', 'aktif', 'history'));
    }

    public function rentalDetail($id)
    {
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with(['barang.user', 'pembayaran'])->findOrFail($id);

        return view('profile.MyRentalsProdukPage', compact('user', 'trx'));
    }

    public function pengembalian($id)
    {
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        return view('profile.MyRentalsPengembalianPage', compact('user', 'trx'));
    }

    // ===== SIMPAN PENGEMBALIAN + REVIEW (rating & ulasan) KE DATABASE =====
    public function storePengembalian(Request $request, $id)
    {
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Silakan beri rating bintang terlebih dahulu.',
            'rating.min'      => 'Silakan beri rating bintang terlebih dahulu.',
        ]);

        // Simpan / perbarui review untuk transaksi ini (1 review per transaksi)
        Review::updateOrCreate(
            ['transaksi_id' => $trx->id],
            [
                'user_id'   => $user->id,
                'barang_id' => $trx->barang_id,
                'rating'    => $validated['rating'],
                'komentar'  => $validated['ulasan'] ?? null,
            ]
        );

        // Tandai pengembalian sedang menunggu verifikasi owner
        $trx->update([
            'status'                 => 'tunggu verifikasi pengembalian',
            'tanggal_kembali_aktual' => $trx->tanggal_kembali_aktual ?? now(),
        ]);

        return redirect()
            ->route('profile.rentals.confirmation', $trx->id)
            ->with('success', 'Pengembalian & ulasan berhasil dikirim!');
    }

    public function confirmation($id)
    {
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        return view('profile.MyRentalsConfirmationPage', compact('user', 'trx'));
    }

    // ===== RENTALS OWNER (barang milik user yang disewa orang lain) =====
    public function owner()
    {
        $user = Auth::user();

        $aktif = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang', 'user'])
            ->whereIn('status', self::STATUS_AKTIF)
            ->latest()
            ->get();

        $history = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang', 'user'])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('profile.MyRentalsOwnerPage', compact('user', 'aktif', 'history'));
    }

    public function ownerDetail($id)
    {
        $user = Auth::user();
        $trx = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang.user', 'user', 'pembayaran', 'review.user'])
            ->findOrFail($id);

        return view('profile.MyRentalsOwnerProdukPage', compact('user', 'trx'));
    }

    // ===== OWNER MENYETUJUI PENGEMBALIAN (Return Rent -> Completed Rent) =====
    public function acceptPengembalian(Request $request, $id)
    {
        $user = Auth::user();
        $trx = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with('barang')
            ->findOrFail($id);

        // Setujui pengembalian -> transaksi selesai
        $trx->update([
            'status'                         => 'selesai',
            'tanggal_verifikasipengembalian' => now(),
            'tanggal_kembali_aktual'         => $trx->tanggal_kembali_aktual ?? now(),
        ]);

        // Barang kembali tersedia
        if ($trx->barang) {
            $trx->barang->update(['status' => 'tersedia']);
        }

        return redirect()
            ->route('profile.owner.produk', $trx->id)
            ->with('success', 'Pengembalian disetujui. Transaksi selesai & barang kembali tersedia.');
    }

    // ===== MY WALLET =====
    public function wallet()
    {
        $user = Auth::user();

        $transaksi = TransaksiPenyewaan::where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhereHas('barang', function($qb) use ($user) {
                  $qb->where('user_id', $user->id);
              });
        })->with(['barang.user', 'pembayaran'])->latest()->get();

        return view('profile.MyWalletPage', compact('user', 'transaksi'));
    }
}
