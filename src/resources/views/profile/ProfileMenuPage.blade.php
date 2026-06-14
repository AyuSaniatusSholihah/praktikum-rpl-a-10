@php
    $fotoProfil = $user->foto_profil
        ? asset('storage/' . $user->foto_profil)
        : asset('assets/img/default-avatar.svg');
@endphp

<x-profile-layout active="profile" pageTitle="Profile">

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 16px; padding: 12px; background: #d1e7dd; color: #0f5132; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom: 16px; padding: 12px; background: #f8d7da; color: #842029; border-radius: 8px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dash-content-card">
        <h1 class="profile-greeting">Hello, <span>{{ $user->name }}!</span></h1>
        <p class="profile-greeting-sub">Here is your quick overview</p>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="profile-avatar-wrap">
            <div class="profile-avatar" style="overflow: hidden;">
            <img src="{{ $fotoProfil }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'"/>
            </div>
            <label for="avatarInput" class="btn-edit-avatar">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            Edit
            </label>
            <input type="file" name="foto_profil" id="avatarInput" accept="image/*" style="display:none"/>
        </div>

        <div class="profile-grid">
            <!-- LEFT -->
            <div class="profile-left">
                <div class="profile-field">
                <label for="accName">Name Account User</label>
                <input type="text" name="name" id="accName" value="{{ old('name', $user->name) }}"/>
                </div>
                <div class="profile-field">
                <label for="accEmail">Email</label>
                <input type="email" id="accEmail" value="{{ $user->email }}" readonly title="Email tidak dapat diubah di sini"/>
                </div>
                <div class="profile-field">
                <label for="accPass">Password</label>
                <input type="password" name="password" id="accPass" placeholder="••••••••" autocomplete="new-password"/>
                </div>
                <div class="profile-field">
                <label for="accPhone">Nomor Telepon</label>
                <input type="tel" name="phone_number" id="accPhone" value="{{ old('phone_number', $user->phone_number) }}"/>
                </div>
                <div class="profile-field">
                <label for="accBirth">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir" id="accBirth" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" placeholder="Contoh: Bandung, 17 September 1995"/>
                </div>
                <div class="profile-field">
                <label for="accGender">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="accGender">
                    <option value="" disabled {{ old('jenis_kelamin', $user->jenis_kelamin) ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                </div>
                <div class="profile-field">
                <label for="accAddress">Alamat</label>
                <textarea name="alamat" id="accAddress" rows="4">{{ old('alamat', $user->alamat) }}</textarea>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="profile-right">
                <div class="saldo-card">
                <svg class="saldo-bg" width="350" height="200" viewBox="0 0 350 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M255.086 5.97015C248.348 16.0669 244.419 28.1983 244.419 41.2475V45.3198C244.419 80.4647 272.911 108.956 308.056 108.956C321.486 108.955 333.944 104.794 344.213 97.6909V176C344.213 189.255 333.468 200 320.213 200H24C10.7453 200 0.000164583 189.255 0 176V29.9702C1.05835e-05 16.7153 10.7452 5.97015 24 5.97015H255.086Z" fill="#B2C9DD"/>
                    <rect x="266.617" y="0.5" width="82.8838" height="85.5672" rx="29.5" fill="white" fill-opacity="0.16" stroke="url(#paint0_linear)"/>
                    <rect x="34.7129" y="29.8508" width="44" height="23" rx="6" fill="white" fill-opacity="0.5"/>
                    <text x="38" y="46" font-family="Inter" font-size="11" font-weight="600" fill="#1D4734">+2.3%</text>
                    <g clip-path="url(#clip0)">
                    <path d="M308.057 26.8657V35.0747M308.057 59.7015V51.4926" stroke="#B2C9DD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M315.288 32.8358H304.441C303.098 32.8358 301.811 33.3862 300.862 34.3659C299.912 35.3456 299.379 36.6743 299.379 38.0597C299.379 39.4452 299.912 40.7739 300.862 41.7536C301.811 42.7332 303.098 43.2836 304.441 43.2836H311.672C313.015 43.2836 314.302 43.834 315.252 44.8137C316.201 45.7933 316.734 47.122 316.734 48.5075C316.734 49.893 316.201 51.2217 315.252 52.2013C314.302 53.181 313.015 53.7314 311.672 53.7314H299.379" stroke="#B2C9DD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear" x1="319.629" y1="-100" x2="301.152" y2="151.41" gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" stop-opacity="0.58"/>
                        <stop offset="1" stop-color="#B2C9DD" stop-opacity="0"/>
                    </linearGradient>
                    <clipPath id="clip0">
                        <rect width="34.7105" height="35.8209" fill="white" transform="translate(290.701 25.3732)"/>
                    </clipPath>
                    </defs>
                </svg>
                <div class="saldo-texts">
                    <div class="saldo-label">Saldo</div>
                    <div class="saldo-amount">Rp {{ number_format($user->saldo ?? 0, 2, ',', '.') }}</div>
                </div>
                </div>

                <div class="profile-stat">
                <label>Total Transaksi Penyewaan</label>
                <div class="stat-value">{{ $rentalCount }} Kali</div>
                </div>
                <div class="profile-stat">
                <label>Jumlah Katalog Barang</label>
                <div class="stat-value">{{ $katalogCount }} Barang</div>
                </div>
                <button type="submit" class="btn-save-profile" id="btnSaveProfile">SAVE</button>
            </div>
        </div>
        </form>
    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-avatar img').src = e.target.result;
                    document.querySelector('.profile-avatar img').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-profile-layout>
