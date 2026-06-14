@auth
<div id="reviewModal" onclick="if(event.target===this)closeReviewModal()" style="display:none; position:fixed; inset:0; z-index:999; background:rgba(0,0,0,0.5); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); align-items:center; justify-content:center; padding:20px;">
    <div style="width:100%; max-width:600px; max-height:90vh; overflow-y:auto;">

  <h2 class="dash-section-title" style="margin-bottom:4px; color:#21394F; font-family:'Volkhov'; font-size:25px; font-weight:800;">Beri Ulasan untuk SEWAIN</h2>
  <p class="dash-section-sub" style="margin-bottom:16px; color:rgba(255,255,255,0.7); font-family:'Poppins'; font-size:13px;">Bagikan pengalamanmu memakai website SEWAIN.</p>

        @if (session('success'))
            <div style="background:#d4edda; color:#155724; padding:14px 16px; border-radius:8px; margin-bottom:16px; font-family:'Poppins',sans-serif;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="dash-content-card" style="position:relative;">
            @php
                $fotoProfil = (auth()->user()->foto_profil)
                    ? asset('storage/' . auth()->user()->foto_profil)
                    : asset('assets/img/default-avatar.svg');
            @endphp

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <div class="profile-avatar">
                    <img src="{{ $fotoProfil }}" alt="Profile" onerror="this.style.display='none'"/>
                </div>
                <button onclick="closeReviewModal()" style="width:32px; height:32px; border-radius:50%; background:rgba(255,255,255,0.15); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px;">✕</button>
            </div>

            <div class="rd-form-grid" style="margin-bottom:24px; padding-left:0 !important;">
                <div class="rd-field"><label>Nama Account User</label><div class="rd-value">{{ auth()->user()->name }}</div></div>
                <div class="rd-field"><label>Email</label><div class="rd-value">{{ auth()->user()->email }}</div></div>
            </div>

            <div class="return-box-title" style="text-align:center; margin-left:0 !important;">FORM ULASAN WEBSITE SEWAIN</div>

            <div class="return-box" style="margin-left:0 !important;">
                <form method="POST" action="{{ route('review-web.store') }}" id="webReviewFormModal">
                    @csrf
                    <div class="return-box-field-label">Rating</div>
                    <div class="return-box-stars" id="ratingStarsModal" style="font-size:26px; color:#FACA43; cursor:pointer; user-select:none; letter-spacing:3px; margin-bottom:14px;">
                        <span data-val="1">☆</span><span data-val="2">☆</span><span data-val="3">☆</span><span data-val="4">☆</span><span data-val="5">☆</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingInputModal" value="0">
                    <div class="return-box-field-label">Ulasan</div>
                    <textarea class="return-box-textarea" name="ulasan" placeholder="Tulis ulasanmu tentang SEWAIN di sini...">{{ old('ulasan') }}</textarea>
                </form>
            </div>

            <div style="display:flex; justify-content:center; margin-top:20px;">
                <button type="submit" form="webReviewFormModal" title="Kirim ulasan"
                    style="width:64px; height:64px; border-radius:50%; background:#6A87A1; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(106,135,161,0.45); transition:transform .15s ease;"
                    onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <svg width="30" height="26" viewBox="0 0 59 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:4px;">
                        <path d="M0 49.3333V0L58.5833 24.6667L0 49.3333ZM6.16667 40.0833L42.7042 24.6667L6.16667 9.25V20.0417L24.6667 24.6667L6.16667 29.2917V40.0833ZM6.16667 40.0833V24.6667V9.25V20.0417V29.2917V40.0833Z" fill="#ffffff"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endauth
