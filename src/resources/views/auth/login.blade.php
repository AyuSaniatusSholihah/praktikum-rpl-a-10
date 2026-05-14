<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - {{ config('app.name', 'Sewain') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        .login-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .sidebar-image {
            background-image: url('{{ asset('login_sidebar.png') }}');
            background-size: cover;
            background-position: center;
        }
        .logo-text {
            font-size: 2.5rem;
            font-weight: 700;
            color: #334155;
            letter-spacing: -0.02em;
        }
        .logo-accent {
            color: #64748b;
            font-weight: 400;
        }
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s;
        }
        .social-btn:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-weight: 600;
            margin: 24px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #f1f5f9;
        }
        .divider:not(:empty)::before { margin-right: 1.5em; }
        .divider:not(:empty)::after { margin-left: 1.5em; }

        .input-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .input-field {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 2px solid #f1f5f9;
            font-size: 1rem;
            color: #1e293b;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-field:focus {
            border-color: #64748b;
        }
        .btn-primary {
            width: 100%;
            padding: 14px;
            background-color: #64748b;
            color: white;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 24px;
            transition: opacity 0.2s;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .btn-secondary {
            width: 100%;
            padding: 14px;
            background-color: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 12px;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background-color: #f8fafc;
        }
        .footer-link {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
        }
        .footer-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">
        <!-- Sidebar Image -->
        <div class="hidden md:block w-1/2 sidebar-image min-h-[600px]"></div>
        
        <!-- Form Section -->
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-12">
                <h1 class="logo-text">SEWA<span class="logo-accent">IN</span></h1>
            </div>

            <h2 class="text-2xl font-semibold text-slate-800 mb-8">Sign In To SEWA<span class="logo-accent">IN</span></h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('auth.redirect') }}" class="social-btn">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Sign up with Google
                </a>
                <button class="social-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Sign up with Email
                </button>
            </div>

            <div class="divider">OR</div>

            <form action="#" method="POST">
                @csrf
                <div class="input-group mb-6">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email">
                </div>

                <div class="input-group mb-2">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password">
                </div>

                <div class="text-right mb-6">
                    <a href="#" class="footer-link">Forget Password?</a>
                </div>

                <button type="submit" class="btn-primary shadow-lg shadow-slate-200">Sign In</button>
                <a href="{{ route('register') }}" class="btn-secondary block text-center">Register Now</a>
            </form>

            <div class="mt-12 text-center">
                <a href="#" class="footer-link uppercase tracking-wider">SEWAIN Terms & Conditions</a>
            </div>
        </div>
    </div>
</body>
</html>
