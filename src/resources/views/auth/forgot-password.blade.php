<x-auth-layout title="Forget Password">
        <form action="{{ route('password.email') }}" method="POST">
          @csrf
          <div class="auth-field">
            <div class="field-row">
              <div>
                <input type="text" id="firstName" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" />
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
                <input type="email" id="email" name="email" placeholder="Email Address" required value="{{ old('email') }}" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Format email tidak valid. Pastikan menggunakan domain yang benar (contoh: .com, .id)." />
                @error('email') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
              <div>
                <input type="tel" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" maxlength="15" />
                @error('phone') <small style="color: #ef4444;">{{ $message }}</small> @enderror
              </div>
            </div>
          </div>
          <button type="submit" class="btn-auth">Send Confirmation Code</button>
        </form>

        <div class="auth-links">Already have an account? <a href="{{ route('login') }}">Login</a></div>
</x-auth-layout>
