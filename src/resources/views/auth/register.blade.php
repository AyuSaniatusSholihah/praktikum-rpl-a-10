<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buat Akun — SEWAIN</title>


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
      background-image: url('assets/img/register_login.png');
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
      justify-content: flex-start;
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

    .social-btn {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 9px 16px;
      border: 1.5px solid var(--blue);
      border-radius: 7px;
      background: #fff;
      font-family: 'Poppins', sans-serif;
      font-size: 11px;
      font-weight: 500;
      color: #333;
      cursor: pointer;
      transition: background .15s, border-color .15s;
      margin-bottom: 14px;
      text-decoration: none;
    }
    .social-btn:hover { background: #f5f5f5; border-color: #5b7891; }

    .auth-divider {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 12px;
      color: #838383;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      margin-bottom: 12px;
    }
    .auth-divider::before,
    .auth-divider::after {
      content: '';
      width: 24px;
      height: 2px;
      background: #838383;
    }

    /* Fields */
    .auth-field { margin-bottom: 10px; }

    .auth-field input {
      width: 100%;
      border: none;
      border-bottom: 1.5px solid #C7C7C7;
      padding: 8px 0 5px;
      font-family: 'Poppins', sans-serif;
      font-size: 10px;
      font-weight: 300;
      color: #555;
      background: transparent;
      outline: none;
      transition: border-color .2s;
    }
    .auth-field input::placeholder { color: #9D9D9D; font-weight: 300; }
    .auth-field input:focus { border-bottom-color: #9D9D9D; }

    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

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
      margin-top: 12px;
      font-size: 10.5px;
      color: var(--black);
      text-align: right;
      font-family: 'Poppins', sans-serif;
    }
    .auth-footer a { color: var(--black); text-decoration: underline; }

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
      .field-row { grid-template-columns: 1fr; }
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


  <!-- ── Sign Up ── -->
  <main>
    <div class="auth-card">


      <!-- Kiri: foto -->
      <div class="auth-sidebar"></div>


      <!-- Kanan: Form -->
      <div class="auth-form-side">
        <a href="index.html" class="auth-logo">SEWA<span>IN</span></a>


        <h1 class="auth-title">Create Account</h1>


        <a href="{{ route('auth.redirect') }}" class="social-btn" style="text-decoration: none;">
          <svg width="16" height="16" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          Sign up with Google
        </a>


        <div class="auth-divider">OR</div>


        <form action="{{ route('register.post') }}" method="POST">
          @csrf
          <div class="auth-field">
            <div class="field-row">
              <div>
                <input type="text" id="firstName" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required />
                @error('first_name') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
              <div>
                <input type="text" id="lastName" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" />
                @error('last_name') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
            </div>
          </div>
          <div class="auth-field">
            <div class="field-row">
              <div>
                <input type="email" id="regEmail" name="email" autocomplete="email" placeholder="Email Address" value="{{ old('email') }}" required />
                @error('email') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
              <div>
                <input type="tel" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" />
                @error('phone') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
            </div>
          </div>
          <div class="auth-field">
            <div class="field-row">
              <div>
                <input type="password" id="regPassword" name="password" autocomplete="new-password" placeholder="Password" required />
                @error('password') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
              <div>
                <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm Password" required />
              </div>
            </div>
          </div>
          <button type="submit" class="btn-auth">Create Account</button>
        </form>


        <div class="auth-links">Already have an account? <a href="{{ route('login') }}">Login</a></div>
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



</body>
</html>

