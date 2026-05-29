<x-layout>
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}" />
    </x-slot:styles>

    <div class="illustration-wrap">
      <!-- 404 illustration -->
      <img src="{{ asset('assets/img/error.png') }}" alt="404 illustration – person at desk" onerror="this.style.display='none'" />
    </div>

    <div class="text-block" style="padding-bottom: 64px;">
      <h1 class="title-404">Page Not Found</h1>
      <p class="subtitle">
        Oops! Looks like you followed a bad link. If you think this is a problem with us, please tell us.
      </p>
      <a href="{{ route('home') }}" class="btn-home">Back to SEWAIN Home</a>
    </div>
</x-layout>
