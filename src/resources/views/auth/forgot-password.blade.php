<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - {{ config('app.name', 'Sewain') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .login-card { background: white; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .logo-text { font-size: 2.5rem; font-weight: 700; color: #334155; letter-spacing: -0.02em; }
        .logo-accent { color: #64748b; font-weight: 400; }
        .input-group label { display: block; font-size: 0.75rem; font-weight: 600; color: #94a3b8; margin-bottom: 4px; text-transform: uppercase; }
        .input-field { width: 100%; padding: 12px 0; border: none; border-bottom: 2px solid #f1f5f9; font-size: 1rem; color: #1e293b; outline: none; transition: border-color 0.2s; }
        .input-field:focus { border-color: #64748b; }
        .btn-primary { width: 100%; padding: 14px; background-color: #64748b; color: white; border-radius: 12px; font-weight: 600; margin-top: 24px; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }
        .footer-link { font-size: 0.75rem; font-weight: 600; color: #64748b; text-decoration: none; }
        .footer-link:hover { text-decoration: underline; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card w-full max-w-md p-8 md:p-12">
        <div class="mb-12 text-center">
            <h1 class="logo-text">SEWA<span class="logo-accent">IN</span></h1>
        </div>

        <h2 class="text-2xl font-semibold text-slate-800 mb-2">Forgot Password?</h2>
        <p class="text-slate-500 mb-8 text-sm">Enter your email and we'll send you an OTP code to reset your password.</p>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="input-group mb-8">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email" required value="{{ old('email') }}">
            </div>

            <button type="submit" class="btn-primary shadow-lg shadow-slate-200">Send OTP Code</button>
            
            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="footer-link">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
