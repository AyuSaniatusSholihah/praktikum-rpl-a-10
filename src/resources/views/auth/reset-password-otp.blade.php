<x-auth-layout title="Reset Password OTP" :showLogoInTitle="false">
        <x-slot:preTitle>
          <div class="email-icon-wrap">
            <div class="icon-circle">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
              </svg>
            </div>
          </div>
        </x-slot:preTitle>

        <x-slot:subtitle>
          <p class="auth-subtitle">Enter the 4-digit code sent to<br><strong>{{ $email }}</strong></p>
        </x-slot:subtitle>

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

        <x-slot:scripts>
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
        </x-slot:scripts>
</x-auth-layout>
