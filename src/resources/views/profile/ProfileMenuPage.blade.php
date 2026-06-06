@php
    $fotoProfil = $user->foto_profil
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');
@endphp

<x-profile-layout active="profile" pageTitle="Profile">

    <div class="welcome-section">
        <h2>Hello, {{ $user->name }}!</h2>
        <p>Here is your quick overview</p>
    </div>

    {{-- Pesan sukses / error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="content-grid">
        @csrf

        <div class="profile-form">
            <div class="form-group">
                <label>Name Account User:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" value="{{ $user->email }}" readonly title="Email tidak dapat diubah di sini">
            </div>

            <div class="form-group">
                <label>Password Baru: <small>(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" placeholder="••••••••" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru:</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label>Nomor Telepon:</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="username">
            </div>

            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="alamat" rows="4" placeholder="Alamat lengkap...">{{ old('alamat', $user->alamat) }}</textarea>
            </div>
        </div>

        <div class="stats-panel">
            <div class="profile-pic-large">
                <img src="{{ $fotoProfil }}" alt="Profile" width="80" height="80">
            </div>

            <label class="upload-foto">
                <i class="fa-solid fa-camera"></i> Ubah Foto
                <input type="file" name="foto_profil" accept="image/*" hidden>
            </label>

            <div class="saldo-card">
                <div class="saldo-header">
                    <span class="badge">+2.3%</span>
                    <span class="saldo-title">Saldo</span>
                </div>
                <h3>Rp {{ number_format($user->saldo ?? 0, 2, ',', '.') }}</h3>
                <div class="currency-icon">$</div>
            </div>

            <div class="stat-box">
                <label>Total DiSewa:</label>
                <div class="stat-value">{{ $rentalCount }} kali</div>
            </div>

            <div class="stat-box">
                <label>Jumlah Katalog Barang:</label>
                <div class="stat-value">{{ $katalogCount }} Barang</div>
            </div>

            <button type="submit" class="btn-save">SAVE</button>
        </div>
    </form>

    <div class="my-rentals-section">
        <h3>My Rentals</h3>
        @if ($recentRentals->isEmpty())
            <p style="color:#8da4be; font-size:13px;">Belum ada penyewaan. Riwayat sewa Anda akan muncul di sini.</p>
        @else
            <div class="rentals-preview-grid">
                @foreach ($recentRentals as $t)
                    @php
                        $badge = [
                            'aktif'    => ['Active Rent', 'active-rent'],
                            'upcoming' => ['UpComing Rent', 'upcoming'],
                            'selesai'  => ['Selesai', 'upcoming'],
                            'tunggu verifikasi pengembalian' => ['Return Rent', 'active-rent'],
                        ][$t->status] ?? ['Rent', 'upcoming'];
                        $foto = $t->barang && $t->barang->foto_barang ? asset('storage/' . $t->barang->foto_barang) : null;
                    @endphp
                    <a class="rental-card" href="{{ route('profile.rentals.produk', $t->id) }}" style="text-decoration:none;">
                        <span class="status-badge {{ $badge[1] }}">{{ $badge[0] }}</span>
                        @if ($foto)
                            <div class="card-placeholder-img" style="background-image:url('{{ $foto }}'); background-size:cover; background-position:center;"></div>
                        @else
                            <div class="card-placeholder-img"></div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</x-profile-layout>
