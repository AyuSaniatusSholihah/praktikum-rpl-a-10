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
        <h1>Verify your account</h1>
        <p>Thank you for registering with SEWAIN. Please use the following 4-digit OTP code to verify your account:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>This code will expire in 10 minutes.</p>
        <div class="footer">
            &copy; {{ date('Y') }} SEWAIN. All rights reserved.
        </div>
    </div>
</body>
</html>
