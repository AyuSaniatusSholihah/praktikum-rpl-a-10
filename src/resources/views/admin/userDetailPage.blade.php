<x-admin-layout title="User Detail - SEWAIN Admin">
<!-- USER DETAIL PAGE -->
    <section class="page-section" id="page-user-detail">

      {{-- Flash Messages --}}
      @if(session('success'))
        <div style="background:#E8F5E9; border:1px solid #A5D6A7; color:#2E7D32; padding:12px 18px; border-radius:8px; margin-bottom:16px; font-family:'Poppins',sans-serif; font-size:13px; display:flex; align-items:center; gap:8px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div style="background:#FFEBEE; border:1px solid #EF9A9A; color:#C62828; padding:12px 18px; border-radius:8px; margin-bottom:16px; font-family:'Poppins',sans-serif; font-size:13px; display:flex; align-items:center; gap:8px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ session('error') }}
        </div>
      @endif

      <button class="btn-back" onclick="location.href='{{ route('admin.users') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Users
      </button>
      <div class="page-title">Data User</div>

        <div class="detail-card">
          <div class="detail-header">

            <!-- KOLOM KIRI: foto doang -->
            <div style="position:relative; flex-shrink:0;">
              <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('assets/img/default-avatar.svg') }}" alt="{{ $user->name }}" class="detail-avatar" id="detail-avatar" onerror="this.src='{{ asset('assets/img/default-avatar.svg') }}'">
            </div>

            <!-- KOLOM KANAN: SEMUA konten masuk sini -->
            <div style="flex:1; min-width:0;">

              <!-- Nama + BAN -->
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div class="detail-title" id="detail-name">{{ $user->name }}</div>
                <form action="{{ route('admin.users.ban', $user->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('{{ $user->is_banned ? 'Unban user ini?' : 'Ban user ini? User tidak dapat melakukan aktivitas apapun di SEWAIN.' }}')">
                  @csrf
                  <button type="submit" class="btn-ban {{ $user->is_banned ? 'btn-unban' : '' }}">{{ $user->is_banned ? 'UNBAN' : 'BAN' }}</button>
                </form>
              </div>

              <!-- Field grid -->
              <div class="detail-grid">
                <div class="detail-field">
                  <label>Username</label>
                  <input type="text" id="detail-username" value="{{ $user->username ?? '-' }}" readonly>
                </div>
                <div class="detail-field">
                  <label>Email</label>
                  <input type="text" id="detail-email" value="{{ $user->email }}" readonly>
                </div>
                <div class="detail-field">
                  <label>No. Telephone</label>
                  <input type="text" id="detail-phone" value="{{ $user->phone_number ?? '-' }}" readonly>
                </div>
                <div class="detail-field">
                  <label>Password</label>
                  <input type="password" value="••••••••" readonly>
                </div>
                <div class="detail-field">
                  <label>Saldo</label>
                  <input type="text" value="Rp {{ number_format($user->saldo, 0, ',', '.') }}" readonly>
                </div>
                <div class="detail-field" style="grid-row: span 2;">
                  <label>Address</label>
                  <textarea readonly id="detail-address" style="min-height:120px;">{{ $user->alamat ?? '-' }}</textarea>
                </div>
                <div class="detail-field">
                  <label>Bergabung</label>
                  <input type="text" value="{{ optional($user->created_at)->translatedFormat('d F Y') }}" readonly>
                </div>
              </div>

              <!-- Katalog Items -->
              <div id="owner-catalog-section">
                <div class="section-header">
                  <h3>Katalog Items</h3>
                </div>
                @php
                  $allReviews = $user->barangs->flatMap->reviews;
                  $avgRating = $allReviews->count() ? round($allReviews->avg('rating'), 1) : null;
                @endphp
                <div style="margin-bottom:12px;">
                  <div class="rating-box">
                    <span style="color:#F59E0B; font-weight:700;">★</span>
                    <span>{{ $avgRating ? $avgRating . ' (' . $allReviews->count() . ' Reviews)' : 'Belum ada review' }}</span>
                  </div>
                </div>
                <div class="catalog-grid">
                  @foreach($user->barangs as $barang)
                  <div class="catalog-card">
                    <span class="catalog-badge {{ $barang->status === 'tidak_tersedia' ? 'active' : '' }}">{{ $barang->status === 'tidak_tersedia' ? 'ACTIVE RENTAL' : 'AVAILABLE' }}</span>
                    <div class="product-img">
                      <img src="{{ $barang->foto_barang ? asset('storage/' . $barang->foto_barang) : 'https://placehold.co/300x200?text=No+Image' }}" alt="{{ $barang->nama_barang }}" onerror="this.src='https://placehold.co/300x200?text=No+Image'">
                    </div>
                    <div class="catalog-card-info">
                      <div class="head-row">
                        <h5>{{ $barang->nama_barang }}</h5>
                      </div>
                      <div class="loc">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $barang->lokasi ?? '-' }}
                      </div>
                      <div class="reviews">({{ $barang->reviews->count() }}) Customer Reviews</div>
                      <div class="price">Rp {{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</div>
                      <div class="stock-footer">
                        <svg width="16" height="14" viewBox="0 0 20 17" fill="none"><path d="M17.4997 5.16667V16H2.49967V5.16667M8.33301 8.5H11.6663M0.833008 1H19.1663V5.16667H0.833008V1Z" stroke="#484848" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>{{ $barang->stok }} Units in Stock</span>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>

                <!-- Transactions -->
                @if($walletTransactions->count() > 0)
                <div id="reviews-section">
                  <div class="reviews-header">
                    <h3>Transactions</h3>
                  </div>
                  <div class="txn-grid">
                    @foreach($walletTransactions as $trx)
                    @php
                        $badgeClass = 'pembayaran-badge';
                        $badgeText = 'Pembayaran Sewa';
                        $amountPrefix = '-';
                        if ($trx->barang && $trx->barang->user_id === $user->id) {
                            $badgeClass = 'pemasukan-badge';
                            $badgeText = 'Pemasukan Sewa';
                            $amountPrefix = '+';
                        }
                    @endphp
                    <div class="txn-card-1-wrapper">
                      <div class="txn-card">
                        <div class="txn-img-wrap">
                          <div class="txn-foto">
                            <img src="{{ optional($trx->barang)->foto_barang ? asset('storage/' . $trx->barang->foto_barang) : 'https://placehold.co/238x169?text=No+Image' }}" alt="" style="width:238px;height:169px;object-fit:cover;border-radius:20px;" onerror="this.src='https://placehold.co/238x169?text=No+Image'">
                          </div>
                          <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                        </div>
                        <div class="txn-card-info">
                          <h5>{{ $trx->barang->nama_barang ?? '-' }}</h5>
                          <div class="loc">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ optional($trx->barang)->lokasi ?? '-' }}
                          </div>
                          <div class="amount">{{ $amountPrefix }} Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                          <div class="date-row">Tanggal Sewa: {{ optional($trx->tanggal_sewa)->format('d/m/Y') }} s.d {{ optional($trx->tanggal_kembali_rencana)->format('d/m/Y') }}</div>
                          <div class="date-row">Tanggal Transaksi: {{ optional($trx->created_at)->format('d/m/Y') }}</div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
                @endif
              </div><!-- akhir #owner-catalog-section -->

            </div><!-- akhir kolom kanan -->
          </div><!-- akhir .detail-header -->
        </div><!-- akhir .detail-card -->
    </section>

<x-slot:scripts>
<script>
function showTxnDetail() {
    location.href = '{{ route('admin.transactions') }}';
  }

  function showItemDetail() {
    location.href = '{{ route('admin.items') }}';
  }

  function showUserDetail(id) {
    location.href = '/admin/users/' + id;
  }

  

function adjustTxnShape() {
  document.querySelectorAll('.txn-card').forEach(card => {
    const cardHeight = card.offsetHeight;
    const baseHeight = 355;
    const scale = cardHeight / baseHeight;
    card.style.setProperty('--scale-y', scale);
    console.log(cardHeight, scale); // buat cek di console
  });
}

// Jalanin setelah semua konten siap
setTimeout(adjustTxnShape, 100);
window.addEventListener('resize', adjustTxnShape);
</script>
</x-slot:scripts>
</x-admin-layout>
