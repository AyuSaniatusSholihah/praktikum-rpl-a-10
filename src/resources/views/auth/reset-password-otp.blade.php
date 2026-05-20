<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Reset OTP - {{ config('app.name', 'Sewain') }}</title>
    
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-slate-800 mb-2">Reset Password OTP</h2>
            <p class="text-slate-500 mb-8">Enter the 4-digit code sent to<br><span class="font-semibold text-slate-700">{{ $email }}</span></p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.otp.verify') }}" method="POST" id="otp-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="flex justify-center gap-4 mb-8">
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" autofocus required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                </div>
                
                <button type="submit" class="btn-primary shadow-lg shadow-slate-200">Verify & Proceed</button>
            </form>

            <div class="mt-8">
                <p class="text-sm text-slate-500">Didn't receive a code? <a href="#" class="font-bold text-slate-700 hover:underline">Resend Now</a></p>
            </div>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 0 && index < inputs.length - 1) inputs[index + 1].focus();
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) inputs[index - 1].focus();
            });
        });
    </script>
</body>
</html>
