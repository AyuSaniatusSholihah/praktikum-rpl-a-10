<x-admin-layout title="Item Detail - SEWAIN Admin" scrollable>
<!-- ITEM DETAIL PAGE -->
    <section class="page-section" id="page-item-detail">
      <button class="btn-back" onclick="location.href='{{ route('admin.items') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Items
      </button>
      <div class="page-title">Data Items</div>

      <div class="detail-card">
        <div class="detail-header">


            <!-- KOLOM KIRI: foto utama + foto produk tambahan -->
            <div style="position:relative; flex-shrink:0; display:flex; flex-direction:column; gap:8px;">
              <span class="badge {{ $item->statusBadgeClass() }}"
                style="position:absolute; top:-8px; left:-16px; z-index:2; box-shadow:0 2px 8px rgba(0,0,0,0.18);">
                {{ $item->statusLabel() }}
              </span>
              <img src="{{ $item->foto_barang ? asset('storage/' . $item->foto_barang) : 'https://placehold.co/120x120?text=No+Image' }}" alt="{{ $item->nama_barang }}" class="detail-avatar" style="border-radius:10px;width:80px;height:80px;object-fit:cover;" onerror="this.src='https://placehold.co/120x120?text=No+Image'">
              @php $fotoTambahan = array_filter([$item->fotoproduk1, $item->fotoproduk2, $item->fotoproduk3, $item->fotoproduk4]); @endphp
              @if(count($fotoTambahan))
              <div style="display:flex; gap:6px; flex-wrap:wrap; max-width:120px;">
                @foreach($fotoTambahan as $foto)
                  <img src="{{ asset('storage/' . $foto) }}" alt="Foto produk" style="width:36px;height:36px;border-radius:6px;object-fit:cover;border:1px solid #cbd7de;">
                @endforeach
              </div>
              @endif
            </div>

            <!-- KOLOM KANAN: SEMUA konten masuk sini -->
            <div style="flex:1; min-width:0;">
              <!-- Nama + status -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                  <div class="detail-title">{{ $item->nama_barang }}</div>
                  <form id="form-delete-{{ $item->id }}" action="{{ route('admin.items.delete', $item->id) }}" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-delete" title="Buang item dari katalog" onclick="showAdminConfirm('Buang Item', 'Buang item ini dari katalog? Tindakan ini tidak dapat dibatalkan.', 'form-delete-{{ $item->id }}')">
                      <svg width="100" height="100" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5312 3.23438H13.6562V1.4375C13.6562 0.644629 13.0116 0 12.2188 0H5.03125C4.23838 0 3.59375 0.644629 3.59375 1.4375V3.23438H0.71875C0.321191 3.23438 0 3.55557 0 3.95312V4.67188C0 4.7707 0.0808594 4.85156 0.179688 4.85156H1.53633L2.09111 16.5986C2.12705 17.3646 2.76045 17.9688 3.52637 17.9688H13.7236C14.4918 17.9688 15.1229 17.3668 15.1589 16.5986L15.7137 4.85156H17.0703C17.1691 4.85156 17.25 4.7707 17.25 4.67188V3.95312C17.25 3.55557 16.9288 3.23438 16.5312 3.23438ZM12.0391 3.23438H5.21094V1.61719H12.0391V3.23438Z" fill="#6A87A1"/>
                      </svg>
                    </button>
                  </form>
                </div>

                <div class="item-detail-grid">
                  <!-- KOLOM KIRI FIELD -->
                  <div class="item-col">
                    <div class="detail-field"><label>ID Items</label><input type="text" value="{{ $item->formattedId() }}" readonly></div>
                    <div class="detail-field"><label>Owner</label><input type="text" value="{{ $item->user->name ?? '-' }}" readonly></div>
                    <div class="detail-field"><label>Category</label><input type="text" value="{{ $item->kategori->nama_kategori ?? '-' }}" readonly></div>
                    <div class="detail-field"><label>Price</label><input type="text" value="Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}/hari" readonly></div>
                    <div class="detail-field"><label>No. Telephone</label><input type="text" value="{{ optional($item->user)->phone_number ?? '-' }}" readonly></div>
                    <div class="detail-field grow" style="flex:1;">
                      <label>Description</label>
                      <textarea readonly style="height:100%; min-height:120px; overflow-y:auto;">{{ $item->deskripsi }}</textarea>
                    </div>
                  </div>

                  <!-- KOLOM KANAN FIELD -->
                  <div class="item-col">
                    <div class="detail-field"><label>Jaminan</label><input type="text" value="Rp {{ number_format($item->harga_jaminan, 0, ',', '.') }}" readonly></div>
                    <div class="detail-field"><label>Denda</label><input type="text" value="Rp {{ number_format($item->harga_denda_perjam, 0, ',', '.') }}/jam" readonly></div>
                    <div class="detail-field"><label>Stok</label><input type="text" value="{{ $item->stok }} unit" readonly></div>
                    <div class="detail-field"><label>Address</label><textarea readonly style="min-height:80px; max-height:80px; overflow-y:auto;">{{ $item->lokasi ?? '-' }}</textarea></div>
                    <div class="detail-field grow" style="flex:1;">
                      <label>Additional Information</label>
                      <textarea readonly style="height:100%; min-height:120px; overflow-y:auto;">{{ $item->additional_information ?? 'Belum ada informasi tambahan.' }}</textarea>
                    </div>
                  </div>
                </div>

      <!-- Reviews -->
    <div id="reviews-section">
      <div class="reviews-header">
        <h3>Reviews</h3>
      </div>
      <div style="background:#cbd7de;border-radius:12px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
        @forelse($item->reviews as $review)
        <div class="review-card">
          <div class="review-header">
            <img class="review-avatar" src="{{ optional($review->user)->foto_profil ? asset('storage/' . $review->user->foto_profil) : asset('assets/img/default-avatar.svg') }}" alt="" onerror="this.src='{{ asset('assets/img/default-avatar.svg') }}'">
            <div style="flex:1; min-width:0;">
              <div class="review-name">{{ optional($review->user)->name ?? 'User' }}</div>
              <div class="review-subtitle">{{ optional($review->user)->name ?? 'User' }}</div>
            </div>
              <div style="text-align:right; margin-left: auto;">
                <div class="review-date">{{ optional($review->created_at)->translatedFormat('d F Y') }}</div>
                <span class="rating-stars">{{ str_repeat('★', (int) $review->rating) . str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</span>
              </div>
          </div>
          <div class="review-text">{{ $review->komentar ?? $review->comment ?? '' }}</div>
        </div>
        @empty
        <p style="color:#5a6b78; margin:0;">Belum ada review untuk item ini.</p>
        @endforelse
      </div>
      </div>
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
</script>
</x-slot:scripts>
</x-admin-layout>
