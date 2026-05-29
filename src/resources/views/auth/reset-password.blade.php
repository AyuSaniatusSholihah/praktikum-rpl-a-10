<x-auth-layout title="Enter Your New Password">
        <form action="{{ route('password.update') }}" method="POST" id="newPasswordForm">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}">
          <input type="hidden" name="code" value="{{ $code }}">

          <div class="auth-field">
            <input type="password" id="newPassword" name="password" placeholder="New Password" required minlength="8" />
          </div>
          <div class="auth-field">
            <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirmation Password" required />
          </div>
          <button type="submit" class="btn-auth">Submit</button>
        </form>
</x-auth-layout>
