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
        /** @var \App\Models\User $user */
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
            'alamat'         => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:Laki-laki,Perempuan',
            'foto_profil'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password'       => 'nullable|string|min:8',
        ], [
            'foto_profil.image'  => 'File harus berupa gambar (jpeg, png, jpg, webp).',
            'foto_profil.max'    => 'Ukuran foto maksimal 2 MB.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Catatan: 'email' sengaja TIDAK divalidasi/diupdate -> email terkunci.
        $data = [
            'name'          => $validated['name'],
            'username'      => $validated['username'] ?? $user->username,
            'phone_number'  => $validated['phone_number'] ?? $user->phone_number,
            'alamat'        => $validated['alamat'] ?? $user->alamat,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? $user->tanggal_lahir,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? $user->jenis_kelamin,
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $aktif = $user->transaksiPenyewaan()
            ->with('barang')
            ->whereIn('status', self::STATUS_AKTIF)
            ->latest()
            ->get();

        $history = $user->transaksiPenyewaan()
            ->with('barang')
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->latest()
            ->get();

        return view('profile.MyRentalsPage', compact('user', 'aktif', 'history'));
    }

    public function rentalDetail($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with(['barang.user', 'pembayaran'])->findOrFail($id);

        return view('profile.MyRentalsProdukPage', compact('user', 'trx'));
    }

    public function pengembalian($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        return view('profile.MyRentalsPengembalianPage', compact('user', 'trx'));
    }

    // ===== SIMPAN PENGEMBALIAN + REVIEW (rating & ulasan) KE DATABASE =====
    public function storePengembalian(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
            'foto_buktipengembalian' => 'required|image|max:2048',
        ], [
            'rating.required' => 'Silakan beri rating bintang terlebih dahulu.',
            'rating.min'      => 'Silakan beri rating bintang terlebih dahulu.',
            'foto_buktipengembalian.required' => 'Foto bukti pengembalian wajib diunggah.',
            'foto_buktipengembalian.image'    => 'File harus berupa gambar.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_buktipengembalian')) {
            $fotoPath = $request->file('foto_buktipengembalian')->store('pengembalian', 'public');
        }

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
            'foto_buktipengembalian' => $fotoPath,
        ]);

        return redirect()
            ->route('profile.rentals.confirmation', $trx->id)
            ->with('success', 'Pengembalian & ulasan berhasil dikirim!');
    }

    public function cancelRental(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang.user')->findOrFail($id);

        if ($trx->status !== 'upcoming') {
            return back()->with('error', 'Hanya penyewaan dengan status upcoming yang dapat dibatalkan.');
        }

        $days = \Carbon\Carbon::parse($trx->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($trx->tanggal_kembali_rencana));
        if ($days == 0) $days = 1;

        $harga_kali_jumlah = $trx->total_harga / $days;
        $jaminan = (int) round($harga_kali_jumlah / 2);
        $shipping = 20000;

        $refund_user = $trx->total_harga + $jaminan + $shipping;

        // Refund ke user
        $user->saldo += $refund_user;
        $user->save();

        // Kurangi dari owner
        $owner = $trx->barang->user;
        if ($owner) {
            $owner->saldo -= $trx->total_harga;
            $owner->save();
        }

        // Update status transaksi
        $trx->update(['status' => 'dibatalkan']);

        // Kembalikan stok/status barang
        if ($trx->barang) {
            $trx->barang->stok += $trx->jumlah;
            $trx->barang->status = 'tersedia';
            $trx->barang->save();
        }

        return back()->with('success', 'Penyewaan berhasil dibatalkan. Saldo telah dikembalikan.');
    }

    public function confirmation($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = $user->transaksiPenyewaan()->with('barang')->findOrFail($id);

        return view('profile.MyRentalsConfirmationPage', compact('user', 'trx'));
    }

    // ===== RENTALS OWNER (barang milik user yang disewa orang lain) =====
    public function owner()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $aktif = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang', 'user'])
            ->whereIn('status', self::STATUS_AKTIF)
            ->latest()
            ->get();

        $history = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang', 'user'])
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->latest()
            ->get();

        return view('profile.MyRentalsOwnerPage', compact('user', 'aktif', 'history'));
    }

    public function ownerDetail($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with(['barang.user', 'user', 'pembayaran', 'review.user'])
            ->findOrFail($id);

        return view('profile.MyRentalsOwnerProdukPage', compact('user', 'trx'));
    }

    public function acceptPengembalian(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $trx = TransaksiPenyewaan::whereHas('barang', fn ($q) => $q->where('user_id', $user->id))
            ->with('barang')
            ->findOrFail($id);

        // --- Hitung denda (Opsi 3: Full hour penalty) ---
        // 1. Dapatkan deadline (rencana + waktu_kembali_rencana)
        $tanggalRencana = $trx->tanggal_kembali_rencana instanceof \Carbon\Carbon 
            ? $trx->tanggal_kembali_rencana->format('Y-m-d') 
            : $trx->tanggal_kembali_rencana;
        $waktuRencana = $trx->waktu_kembali_rencana ?? '08:00:00';
        $deadline = \Carbon\Carbon::parse($tanggalRencana . ' ' . $waktuRencana);

        // 2. Dapatkan waktu pengembalian aktual
        $aktual = \Carbon\Carbon::parse($trx->tanggal_kembali_aktual ?? now());

        $jamTerlambat = 0;
        $totalDenda = 0;

        if ($aktual->greaterThan($deadline)) {
            // diffInHours mengembalikan pembulatan ke bawah (floor) jam. 
            // Cth: telat 59 menit = 0 jam. Telat 1 jam 5 menit = 1 jam.
            $jamTerlambat = $deadline->diffInHours($aktual);
            if ($jamTerlambat > 0) {
                $dendaPerJam = $trx->barang->harga_denda_perjam ?? 10000;
                $totalDenda = $jamTerlambat * $dendaPerJam;
            }
        }

        // Setujui pengembalian -> transaksi selesai
        $trx->update([
            'status'                         => 'selesai',
            'tanggal_verifikasipengembalian' => now(),
            'tanggal_kembali_aktual'         => $aktual,
            'jam_terlambat'                  => $jamTerlambat,
            'total_denda'                    => $totalDenda,
        ]);

        // Potong denda dari saldo penyewa dan tambahkan ke owner
        if ($totalDenda > 0 && $trx->user_id) {
            $penyewa = \App\Models\User::find($trx->user_id);
            if ($penyewa) {
                $penyewa->saldo -= $totalDenda;
                $penyewa->save();
            }
            $user->saldo += $totalDenda;
            $user->save();
        }

        // Barang kembali tersedia — kembalikan stok sesuai jumlah yang disewa
        if ($trx->barang) {
            $trx->barang->stok += $trx->jumlah;
            $trx->barang->status = ($trx->barang->stok > 0) ? 'tersedia' : 'tidak_tersedia';
            $trx->barang->save();
        }

        $msg = 'Pengembalian disetujui. Transaksi selesai & barang kembali tersedia.';
        if ($totalDenda > 0) {
            $msg .= ' Penyewa terlambat ' . $jamTerlambat . ' jam penuh. Denda Rp ' . number_format($totalDenda, 0, ',', '.') . ' otomatis ditambahkan ke saldo Anda.';
        }

        return redirect()
            ->route('profile.owner.produk', $trx->id)
            ->with('success', $msg);
    }

    // ===== MY WALLET =====
    public function wallet()
    {
        /** @var \App\Models\User $user */
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
