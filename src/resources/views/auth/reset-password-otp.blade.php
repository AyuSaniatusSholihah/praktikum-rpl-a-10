<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password OTP — SEWAIN</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Jomolhari&family=Poppins:wght@300;400;500;600;700&family=Vidaloka&family=Volkhov:wght@400;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --blue:    #6A87A1;
      --black:   #000000;
      --bg:      #f4f4f4;
      --bg-outer:#B9C8D6;
      --nav-h:   56px;
    }

    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── Navbar ── */
    nav {
      height: var(--nav-h);
      background: #fff;
      display: flex;
      align-items: center;
      padding: 0 32px;
      border-bottom: 1px solid #e8e8e8;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .nav-logo {
      font-family: 'Vidaloka', serif;
      font-size: 35px;
      font-weight: 400;
      letter-spacing: 0.04em;
      color: #484848;
      text-decoration: none;
    }
    .nav-logo span { color: var(--blue); }
    .nav-links {
      display: flex;
      gap: 28px;
      list-style: none;
      margin-left: 40px;
    }
    .nav-links a {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      color: #444;
      text-decoration: none;
      padding: 4px 2px;
      transition: color .2s;
    }
    .nav-links a.active,
    .nav-links a:hover { color: var(--black); font-weight: 600; }
    .nav-links a.active { border-bottom: 2px solid var(--black); }
    .nav-right {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .nav-right svg { width: 20px; height: 20px; color: #333; cursor: pointer; }

    /* ── Main ── */
    main {
      flex: 1;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }

    /* ── Auth Card ── */
    .auth-card {
      display: flex;
      flex-direction: row;
      align-items: stretch;
      width: 100%;
      max-width: 860px;
      min-height: 460px;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 8px 40px rgba(0,0,0,0.18);
      background: #fff;
    }

    /* ── Left: foto interior ── */
    .auth-sidebar {
      width: 45%;
      flex-shrink: 0;
      height: auto;
      background-image: url('{{ asset('assets/img/register_login.png') }}');
      background-size: 199%;
      background-position: -125px center;
      background-repeat: no-repeat;
      overflow: hidden;
    }
    /* ── Right: Form ── */
    .auth-form-side {
      flex: 1;
      background: #fff;
      padding: 36px 44px 28px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .auth-logo {
      font-family: 'Vidaloka', serif;
      font-size: 28px;
      font-weight: 400;
      letter-spacing: 0.04em;
      color: #484848;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 8px;
    }
    .auth-logo span { color: var(--blue); }

    .auth-title {
      font-family: 'Volkhov', serif;
      font-size: 16px;
      font-weight: 700;
      color: var(--black);
      margin-bottom: 16px;
    }

    /* Fields */
    .auth-field { margin-bottom: 10px; }

    .btn-auth {
      width: 100%;
      padding: 10px;
      background: var(--blue);
      color: #fff;
      border: none;
      border-radius: 7px;
      font-family: 'Poppins', sans-serif;
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      margin-top: 12px;
      transition: opacity .2s, box-shadow .2s;
      box-shadow: 0 8px 20px rgba(106, 135, 161, 0.18);
    }
    .btn-auth:hover { opacity: .88; }

    .auth-links {
      margin-top: 12px;
      font-size: 10px;
      color: var(--black);
      text-align: center;
      font-family: 'Poppins', sans-serif;
    }
    .auth-links a {
      color: var(--blue);
      font-family: 'Poppins', sans-serif;
      font-size: 11px;
      font-weight: 800;
      text-decoration: none;
    }
    .auth-links a:hover { text-decoration: underline; }

    .auth-footer {
      margin-top: auto;
      font-size: 10.5px;
      color: var(--black);
      text-align: right;
      font-family: 'Poppins', sans-serif;
    }
    .auth-footer a { color: var(--black); text-decoration: underline; }

    /* ── OTP specific ── */
    .email-icon-wrap {
      display: flex;
      justify-content: center;
      margin-bottom: 12px;
    }
    .email-icon-wrap .icon-circle {
      width: 52px;
      height: 52px;
      background: var(--blue);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .email-icon-wrap .icon-circle svg {
      width: 26px;
      height: 26px;
      color: #fff;
    }

    .auth-subtitle {
      font-size: 10px;
      color: #888;
      text-align: center;
      font-family: 'Poppins', sans-serif;
      margin-bottom: 20px;
    }

    .otp-row {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-bottom: 15px;
    }
    .otp-input {
      width: 48px;
      height: 48px;
      border: none;
      border-radius: 6px;
      background: #E8E8E8;
      text-align: center;
      font-family: 'Poppins', sans-serif;
      font-size: 18px;
      font-weight: 600;
      color: #333;
      outline: none;
      transition: background .2s, box-shadow .2s;
    }
    .otp-input:focus {
      background: #d8e4ed;
      box-shadow: 0 0 0 2px var(--blue);
    }

    /* ── Footer ── */
    footer {
      background: #e2e2e2;
      padding: 40px 24px 28px 24px;
      margin-top: auto;
    }
    .footer-inner {
      width: 100%;
      display: flex;
      gap: 32px;
      align-items: flex-start;
      justify-content: space-between;
    }
    .footer-brand {
      flex: 0 0 220px;
      padding-left: 24px;
    }
    .footer-logo {
      font-family: 'Vidaloka', serif;
      font-size: 35px;
      font-weight: 400;
      color: #484848;
      letter-spacing: 0.04em;
    }
    .footer-logo span { color: var(--blue); }
    .footer-tagline {
      font-size: 13px;
      color: #555;
      margin-top: 8px;
      line-height: 1.6;
    }
    .footer-socials {
      display: flex;
      gap: 10px;
      margin-top: 14px;
    }
    .footer-socials a {
      width: 32px; height: 32px;
      background: #ccc;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      text-decoration: none;
      color: #333;
      transition: background .2s;
    }
    .footer-socials a:hover { background: var(--blue); color: #fff; }
    .footer-cols {
      flex: 0 0 auto;
      display: flex;
      gap: 48px;
      margin-left: auto;
      margin-right: 24px;
    }
    .footer-col h4 {
      font-size: 13px;
      font-weight: 700;
      color: var(--black);
      margin-bottom: 12px;
    }
    .footer-col ul { list-style: none; }
    .footer-col ul li { margin-bottom: 8px; }
    .footer-col ul li a {
      font-size: 13px;
      color: #555;
      text-decoration: none;
      transition: color .2s;
    }
    .footer-col ul li a:hover { color: var(--blue); }
    .footer-bottom {
      width: 100%;
      margin: 28px 0 0;
      padding: 16px 24px 0;
      border-top: 1px solid #ccc;
      font-size: 12px;
      color: #888;
    }

    /* Mobile */
    @media (max-width: 640px) {
      .auth-sidebar { display: none; }
      .auth-form-side { padding: 28px 24px; }
    }
  </style>
</head>
<body>

  <!-- ── Navbar ── -->
  <nav>
    <a href="index.html" class="nav-logo">SEWA<span>IN</span></a>
    <ul class="nav-links">
      <li><a href="index.html">Home</a></li>
      <li><a href="rentals.html">Rentals</a></li>
      <li><a href="katalog.html">My Katalog</a></li>
    </ul>
    <div class="nav-right">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
      </svg>
    </div>
  </nav>

  <!-- ── Reset Password OTP ── -->
  <main>
    <div class="auth-card">

      <!-- Kiri: foto -->
      <div class="auth-sidebar"></div>

      <!-- Kanan: Form -->
      <div class="auth-form-side">
        <a href="index.html" class="auth-logo">SEWA<span>IN</span></a>

        <!-- Email Icon -->
        <div class="email-icon-wrap">
          <div class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
          </div>
        </div>

        <h1 class="auth-title" style="text-align:center;">Reset Password OTP</h1>
        <p class="auth-subtitle">Enter the 4-digit code sent to<br><strong>{{ $email }}</strong></p>

        @if ($errors->any())
            <div style="background-color: #ffe4e6; border: 1px solid #fecdd3; color: #e11d48; padding: 10px; border-radius: 7px; margin-bottom: 14px; font-size: 11px; text-align: center;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.otp.verify') }}" method="POST" id="otp-form">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}">
          <div class="otp-row">
            <input type="text" name="otp[]" class="otp-input" maxlength="1" inputmode="numeric" pattern="\d*" required autofocus autocomplete="off" />
            <input type="text" name="otp[]" class="otp-input" maxlength="1" inputmode="numeric" pattern="\d*" required autocomplete="off" />
            <input type="text" name="otp[]" class="otp-input" maxlength="1" inputmode="numeric" pattern="\d*" required autocomplete="off" />
            <input type="text" name="otp[]" class="otp-input" maxlength="1" inputmode="numeric" pattern="\d*" required autocomplete="off" />
          </div>
          <button type="submit" class="btn-auth">Verify &amp; Proceed</button>
        </form>

        <div class="auth-links">Didn't receive a code? <a href="#">Resend Now</a></div>
        <p class="auth-footer">SEWAIN Terms &amp; Conditions</p>
      </div>

    </div>
  </main>

  <!-- ── Footer ── -->
  <footer>
    <div class="footer-inner">
      <div class="footer-brand">
        <div class="footer-logo">SEWA<span>IN</span></div>
        <p class="footer-tagline">We help you find<br>and rent what you<br>need easily</p>
        <div class="footer-socials">
          <a href="#">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.558 4.126 1.534 5.857L0 24l6.302-1.513A11.934 11.934 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.891 0-3.665-.523-5.181-1.434l-.371-.219-3.742.898.939-3.635-.242-.386A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
            </svg>
          </a>
          <a href="#">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
          <a href="#">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 20C8.63333 20 7.34167 19.7375 6.125 19.2125C4.90833 18.6875 3.84583 17.9708 2.9375 17.0625C2.02917 16.1542 1.3125 15.0917 0.7875 13.875C0.2625 12.6583 0 11.3667 0 10C0 8.61667 0.2625 7.32083 0.7875 6.1125C1.3125 4.90417 2.02917 3.84583 2.9375 2.9375C3.84583 2.02917 4.90833 1.3125 6.125 0.7875C7.34167 0.2625 8.63333 0 10 0C11.3833 0 12.6792 0.2625 13.8875 0.7875C15.0958 1.3125 16.1542 2.02917 17.0625 2.9375C17.9708 3.84583 18.6875 4.90417 19.2125 6.1125C19.7375 7.32083 20 8.61667 20 10C20 11.3667 19.7375 12.6583 19.2125 13.875C18.6875 15.0917 17.9708 16.1542 17.0625 17.0625C16.1542 17.9708 15.0958 18.6875 13.8875 19.2125C12.6792 19.7375 11.3833 20 10 20Z"/>
            </svg>
          </a>
          <a href="#">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="footer-cols">
        <div class="footer-col">
          <h4>Information</h4>
          <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Product</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><a href="#">Community</a></li>
            <li><a href="#">Career</a></li>
            <li><a href="#">Our Story</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Contact</h4>
          <ul>
            <li><a href="#">Getting Started</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Resources</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      Copyright © 2026 Xpro . All Rights Reserved Term of use SEWAIN
    </div>
  </footer>

  <script>
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length > 0 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').slice(0, 4).split('');
            pasteData.forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                    if (i < inputs.length - 1) inputs[i + 1].focus();
                }
            });
        });
    });
  </script>
</body>
</html>
