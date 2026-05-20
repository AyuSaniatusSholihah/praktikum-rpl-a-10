<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: 'Outfit', sans-serif; padding: 20px; color: #334155; }
        .otp-code { font-size: 32px; font-weight: 700; color: #64748b; letter-spacing: 5px; margin: 20px 0; }
        .footer { font-size: 12px; color: #94a3b8; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset your password</h1>
        <p>You requested to reset your password for your SEWAIN account. Please use the following 4-digit OTP code to proceed:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>This code will expire in 10 minutes. If you did not request a password reset, please ignore this email.</p>
        <div class="footer">
            &copy; {{ date('Y') }} SEWAIN. All rights reserved.
        </div>
    </div>
</body>
</html>
