@props(['title' => 'Sign In To', 'showLogoInTitle' => true])

<x-layout>
  <x-slot:styles>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}" />
  </x-slot:styles>

  <main class="auth-main">
    <div class="auth-card">

      <!-- Kiri: foto interior sofa -->
      <div class="auth-sidebar"></div>

      <!-- Kanan: Form -->
      <div class="auth-form-side">
        <a href="{{ route('home') }}" class="auth-logo">SEWA<span>IN</span></a>

        @if(isset($preTitle))
            {{ $preTitle }}
        @endif

        <h1 class="auth-title" @if(!$showLogoInTitle) style="text-align:center;" @endif>
          {{ $title }}
          @if($showLogoInTitle)
            <span class="sewa">SEWA</span><span>IN</span>
          @endif
        </h1>

        @if(isset($subtitle))
            {{ $subtitle }}
        @endif

        @if (session('success'))
            <div style="background-color: #d1fae5; border: 1px solid #a7f3d0; color: #047857; padding: 10px; border-radius: 7px; margin-bottom: 14px; font-size: 11px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div style="background-color: #fef3c7; border: 1px solid #fde68a; color: #b45309; padding: 10px; border-radius: 7px; margin-bottom: 14px; font-size: 11px;">
                {{ session('warning') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #ffe4e6; border: 1px solid #fecdd3; color: #e11d48; padding: 10px; border-radius: 7px; margin-bottom: 14px; font-size: 11px;">
                <ul style="padding-left: 14px; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="auth-form-body">
            {{ $slot }}
        </div>

        <p class="auth-footer">SEWAIN Terms &amp; Conditions</p>
      </div>

    </div>
  </main>
  
  @if(isset($scripts))
      <x-slot:scripts>
          {{ $scripts }}
      </x-slot:scripts>
  @endif
</x-layout>
