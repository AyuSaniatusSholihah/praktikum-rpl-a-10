<x-layout title="Beri Ulasan — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/profiledashboard.css') }}" />
    </x-slot:styles>

    <section style="max-width:760px; margin:48px auto; padding:0 20px;">
        <h2 class="dash-section-title" style="margin-bottom:4px;">Beri Ulasan untuk SEWAIN</h2>
        <p class="dash-section-sub" style="margin-bottom:24px;">Bagikan pengalamanmu memakai website SEWAIN.</p>

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

        {{-- Data user (otomatis terisi karena sudah login) --}}
        <div class="rd-form-grid" style="margin-bottom:24px;">
            <div class="rd-field"><label>Nama</label><div class="rd-value">{{ $user->name }}</div></div>
            <div class="rd-field"><label>Username</label><div class="rd-value">{{ $user->username ?? '-' }}</div></div>
            <div class="rd-field"><label>Email</label><div class="rd-value">{{ $user->email }}</div></div>
        </div>

        <div class="return-box-title">FORM ULASAN WEBSITE</div>

        <div class="return-box">
            <form method="POST" action="{{ route('review-web.store') }}" id="webReviewForm">
                @csrf

                <div class="return-box-field-label">Review</div>
                <div class="return-box-stars" id="ratingStars" style="font-size:26px; color:#FACA43; cursor:pointer; user-select:none; letter-spacing:3px; margin-bottom:14px;">
                    <span data-val="1">☆</span><span data-val="2">☆</span><span data-val="3">☆</span><span data-val="4">☆</span><span data-val="5">☆</span>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="0">

                <div class="return-box-field-label">Ulasan</div>
                <textarea class="return-box-textarea" name="ulasan" placeholder="Tulis ulasanmu tentang SEWAIN di sini...">{{ old('ulasan') }}</textarea>

                {{-- Tombol kirim: kotak hijau bulat + ikon pesawat kertas putih --}}
                <div style="display:flex; justify-content:center; margin-top:20px;">
                    <button type="submit" title="Kirim ulasan"
                        style="width:64px; height:64px; border-radius:50%; background:#3BA55D; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(59,165,93,0.45); transition:transform .15s ease;"
                        onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                        <svg width="30" height="26" viewBox="0 0 59 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:4px;">
                            <path d="M0 49.3333V0L58.5833 24.6667L0 49.3333ZM6.16667 40.0833L42.7042 24.6667L6.16667 9.25V20.0417L24.6667 24.6667L6.16667 29.2917V40.0833ZM6.16667 40.0833V24.6667V9.25V20.0417V29.2917V40.0833Z" fill="#ffffff"/>
                        </svg>
                    </button>
                </div>
            </form>
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
