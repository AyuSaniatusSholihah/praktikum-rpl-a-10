<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEWAIN - Create Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f4f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 900px;
            min-height: 560px;
            max-width: 100%;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.10);
        }

        .left-panel {
            width: 45%;
            position: relative;
            overflow: hidden;
        }

        .left-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .right-panel {
            width: 55%;
            padding: 48px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #1a1a2e;
            margin-bottom: 28px;
        }

        .logo span {
            font-weight: 400;
            color: #5a7ba6;
        }

        h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 20px;
            font-weight: 500;
            color: #1a1a2e;
            margin-bottom: 20px;
        }

        .social-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
        }

        .btn-social:hover {
            background: #f8f8f8;
            border-color: #bbb;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
            color: #aaa;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 14px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group input {
            border: none;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #333;
            background: transparent;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input::placeholder {
            color: #aaa;
            font-size: 13px;
        }

        .form-group input:focus {
            border-bottom-color: #5a7ba6;
        }

        .form-group .error-msg {
            color: #e53e3e;
            font-size: 11px;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: #5a7ba6;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.2s;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: #4a6a92;
        }

        .login-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #888;
        }

        .login-link a {
            color: #5a7ba6;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: right;
            margin-top: 24px;
            font-size: 11px;
            color: #bbb;
        }

        .terms a {
            color: #bbb;
            text-decoration: none;
        }

        .terms a:hover {
            color: #888;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .alert-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #2f855a;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        @media (max-width: 920px) {
            .container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100%;
            }

            .left-panel {
                height: 220px;
            }

            .right-panel {
                padding: 28px;
            }
        }

        @media (max-width: 640px) {
            .form-row,
            .social-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left-panel">
        <img src="{{ asset('images/sewain-bg.jpg') }}" alt="SEWAIN Interior">
    </div>

    <div class="right-panel">
        <div class="logo">SEW<span>AIN</span></div>

        <h2>Create Account</h2>

        <div class="social-buttons">
            <a href="{{ route('auth.google') }}" class="btn-social">
                <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.15 0 5.64 1.08 7.73 2.84l5.75-5.75C33.91 3.64 29.27 1.5 24 1.5 14.98 1.5 7.3 7.1 4.1 15.01l6.7 5.2C12.4 13.98 17.72 9.5 24 9.5z"/><path fill="#4285F4" d="M46.1 24.5c0-1.64-.15-3.22-.42-4.75H24v9h12.42c-.54 2.9-2.18 5.36-4.63 7.02l7.18 5.57C43.27 37.07 46.1 31.2 46.1 24.5z"/><path fill="#FBBC05" d="M10.8 28.79A14.5 14.5 0 0 1 9.5 24c0-1.67.29-3.28.8-4.79l-6.7-5.2A22.45 22.45 0 0 0 1.5 24c0 3.6.87 7 2.1 10.01l7.2-5.22z"/><path fill="#34A853" d="M24 46.5c5.27 0 9.68-1.74 12.91-4.72l-7.18-5.57c-1.78 1.2-4.06 1.9-5.73 1.9-6.28 0-11.6-4.48-13.2-10.5l-7.2 5.22C7.3 40.9 14.98 46.5 24 46.5z"/><path fill="none" d="M1.5 1.5h45v45h-45z"/></svg>
                Sign up with Google
            </a>
            <a href="{{ route('auth.email') }}" class="btn-social">
                <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true"><path fill="#EA4335" d="M6 40h8V22.4L4 12v24c0 2.2 1.8 4 2 4z"/><path fill="#188038" d="M34 40h8c2.2 0 4-1.8 4-4V12l-12 10.4z"/><path fill="#1967D2" d="M34 8H14L24 16.4 34 8z"/><path fill="#FBBC04" d="M14 22.4V40h20V22.4L24 30.8z"/><path fill="#EA4335" d="M4 12l10 10.4V8H8C5.8 8 4 9.8 4 12z"/><path fill="#188038" d="M44 8h-6v14.4L48 12c0-2.2-1.8-4-4-4z"/></svg>
                Sign up with Email
            </a>
        </div>

        <div class="divider">OR</div>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul style="padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Create Account</button>
        </form>

        <p class="login-link">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>

        <div class="terms">
            <a href="{{ route('terms') }}">SEWAIN Terms &amp; Conditions</a>
        </div>
    </div>
</div>
</body>
</html>
