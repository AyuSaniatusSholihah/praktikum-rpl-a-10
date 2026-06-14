<x-admin-layout title="Data Users - SEWAIN Admin" headerTitle="Data User" scrollable>
<!-- ═══════════════════════════════════════════ -->
    <!-- USERS LIST PAGE -->
    <!-- ═══════════════════════════════════════════ -->
      <div class="users-grid">
        @forelse($users as $u)
        <div class="user-card" onclick="location.href='{{ route('admin.users.detail', $u->id) }}'">
          <img src="{{ $u->foto_profil ? asset('storage/' . $u->foto_profil) : asset('assets/img/default-avatar.svg') }}" alt="{{ $u->name }}" onerror="this.src='{{ asset('assets/img/default-avatar.svg') }}'">
          <div class="user-card-info">
            @if(($u->barangs_count ?? $u->barangs()->count() ?? 0) > 0)
                <span class="owner-badge">OWNER</span>
            @endif
            <h4>{{ $u->name }}</h4>
            <p>{{ $u->email }}</p>
            <button class="btn-view-more">View More</button>
          </div>
        </div>
        @empty
          <p style="grid-column:1/-1; color:#727272; padding:24px;">Belum ada user terdaftar.</p>
        @endforelse
      </div>
</x-admin-layout>
