<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email - {{ config('app.name', 'Sewain') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .login-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .sidebar-image { background-image: url('{{ asset('login_sidebar.png') }}'); background-size: cover; background-position: center; }
        .otp-input { width: 64px; height: 64px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1.5rem; font-weight: 700; text-align: center; color: #1e293b; outline: none; transition: all 0.2s; background-color: #f1f5f9; }
        .otp-input:focus { border-color: #64748b; background-color: white; box-shadow: 0 0 0 4px rgba(100, 116, 139, 0.1); }
        .btn-primary { width: 100%; padding: 14px; background-color: #64748b; color: white; border-radius: 12px; font-weight: 600; margin-top: 24px; transition: all 0.2s; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .footer-link { font-size: 0.75rem; font-weight: 600; color: #64748b; text-decoration: none; }
        .footer-link:hover { text-decoration: underline; }
        .resend-link { color: #64748b; font-weight: 700; text-decoration: none; }
        .resend-link:hover { text-decoration: underline; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">
        <!-- Sidebar Image -->
        <div class="hidden md:block w-1/2 sidebar-image min-h-[600px]"></div>
        
        <!-- Form Section -->
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-slate-800 mb-2">Verify Your Email</h2>
            <p class="text-slate-500 mb-8">We sent a 4-digit code to</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('otp.verify.post') }}" method="POST" id="otp-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="flex justify-center gap-4 mb-8">
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" autofocus required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                </div>
                
                <button type="submit" class="btn-primary shadow-lg shadow-slate-200">Verify Now</button>
            </form>

            <div class="mt-8">
                <p class="text-sm text-slate-500">Didn't receive a code? <a href="#" class="resend-link">Resend Now</a></p>
            </div>

            <div class="mt-24 text-center">
                <a href="#" class="footer-link uppercase tracking-wider">SEWAIN Terms & Codnitions</a>
            </div>
        </div>
    </div>

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
