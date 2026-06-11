<x-layout title="Beri Ulasan — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/profiledashboard.css') }}" />
    </x-slot:styles>
    

    <section style="max-width:760px; margin:48px auto; padding:0 20px;">

    <h2 class="dash-section-title" style="margin-bottom:4px; color:#21394F;">Beri Ulasan untuk SEWAIN</h2>
    <p class="dash-section-sub" style="margin-bottom:24px; color:#6b6b6b;">Bagikan pengalamanmu memakai website SEWAIN.</p>

        @if (session('success'))
            <div style="background:#d4edda; color:#155724; padding:14px 16px; border-radius:8px; margin-bottom:20px; font-family:'Poppins',sans-serif;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:14px 16px; border-radius:8px; margin-bottom:20px; font-family:'Poppins',sans-serif;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="dash-content-card" style="position:relative; ">

            {{-- Foto profil pojok kanan atas --}}
            @php
                $fotoProfil = ($user && $user->foto_profil)
                    ? asset('storage/' . $user->foto_profil)
                    : asset('assets/img/default-avatar.svg');
            @endphp
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div class="profile-avatar">
                <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
            </div>
            <a href="{{ route('home') }}" 
            style="width:32px; height:32px; border-radius:50%; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px; text-decoration:none; transition:background .15s;"
            onmouseover="this.style.background='rgba(255,255,255,0.25)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'"
            title="Kembali">✕</a>
        </div>

            {{-- Info user --}}
            <div class="rd-form-grid" style="margin-bottom:24px; width:100%; padding:0;">
                <div class="rd-field"><label>Nama Lengkap</label><div class="rd-value">{{ $user->name }}</div></div>
                <div class="rd-field"><label>Username</label><div class="rd-value">{{ $user->username ?? '-' }}</div></div>
                <div class="rd-field"><label>Email</label><div class="rd-value">{{ $user->email }}</div></div>
            </div>

            <div class="return-box-title" style="text-align:center; margin-left:0 !important;">FORM ULASAN WEBSITE SEWAIN</div>

            <div class="return-box" style="margin-left: 0 !important;">
                <form method="POST" action="{{ route('review-web.store') }}" id="webReviewForm">
                    @csrf

                    <div class="return-box-field-label">Rating</div>
                    <div class="return-box-stars" id="ratingStars" style="font-size:26px; color:#FACA43; cursor:pointer; user-select:none; letter-spacing:3px; margin-bottom:14px;">
                        <span data-val="1">☆</span><span data-val="2">☆</span><span data-val="3">☆</span><span data-val="4">☆</span><span data-val="5">☆</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="0">

                    <div class="return-box-field-label">Ulasan</div>
                    <textarea class="return-box-textarea" name="ulasan" placeholder="Tulis ulasanmu tentang SEWAIN di sini...">{{ old('ulasan') }}</textarea>
                </form>
            </div>

                <div style="display:flex; justify-content:center; margin-top:20px;">
                    <button type="submit" form="webReviewForm" title="Kirim ulasan"
                        style="width:64px; height:64px; border-radius:50%; background:#6A87A1; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(106,135,161,0.45); transition:transform .15s ease;"
                        onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                        <svg width="30" height="26" viewBox="0 0 59 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:4px;">
                            <path d="M0 49.3333V0L58.5833 24.6667L0 49.3333ZM6.16667 40.0833L42.7042 24.6667L6.16667 9.25V20.0417L24.6667 24.6667L6.16667 29.2917V40.0833ZM6.16667 40.0833V24.6667V9.25V20.0417V29.2917V40.0833Z" fill="#ffffff"/>
                        </svg>
                    </button>
                </div>
        </div>
    </section>

    <x-slot:scripts>
        <script>
            (function () {
                const wrap  = document.getElementById('ratingStars');
                const input = document.getElementById('ratingInput');
                if (!wrap || !input) return;
                const stars = wrap.querySelectorAll('span');
                const paint = (val) => stars.forEach(s => s.textContent = (Number(s.dataset.val) <= val) ? '★' : '☆');
                stars.forEach(s => {
                    s.addEventListener('click', () => { input.value = s.dataset.val; paint(Number(s.dataset.val)); });
                    s.addEventListener('mouseenter', () => paint(Number(s.dataset.val)));
                });
                wrap.addEventListener('mouseleave', () => paint(Number(input.value)));
            })();
        </script>
    </x-slot:scripts>
</x-layout>