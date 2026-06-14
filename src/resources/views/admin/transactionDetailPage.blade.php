<x-admin-layout title="Transactions Detail - SEWAIN Admin" scrollable>
<!-- TRANSACTION DETAIL PAGE -->
    <section class="page-section" id="page-txn-detail">
      <button class="btn-back" onclick="location.href='{{ route('admin.transactions') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Transactions
      </button>
      <div class="page-title">Data Transactions</div>

      <div class="detail-card">
        <div class="detail-header">

            <!-- KOLOM KIRI: foto barang -->
            <div style="position:relative; flex-shrink:0;">
            <span class="badge {{ $transaksi->statusBadgeClass() }}" 
              style="position:absolute; top:-8px; left:-16px; z-index:2; box-shadow:0 2px 8px rgba(0,0,0,0.18);">
              {{ $transaksi->statusLabel() }}
            </span>
              <img src="{{ optional($transaksi->barang)->foto_barang ? asset('storage/' . $transaksi->barang->foto_barang) : 'https://placehold.co/80x80?text=No+Image' }}" alt="" class="detail-avatar" style="border-radius:10px;width:80px;height:80px;object-fit:cover;" onerror="this.src='https://placehold.co/80x80?text=No+Image'">
            </div>

            <!-- KOLOM KANAN: SEMUA konten masuk sini -->
            <div style="flex:1; min-width:0;">

              <!-- Nama + status -->
            <div style="display:flex; align-items:center; margin-bottom:16px;">
              <div class="detail-title">{{ $transaksi->barang->nama_barang ?? '-' }}</div>
            </div>

        <div class="detail-grid">
          <!-- KOLOM KIRI FIELD -->
          <div class="item-col">
            <div class="detail-field"><label>ID Transaction</label><input type="text" value="{{ $transaksi->formattedId() }}" readonly></div>
            <div class="detail-field"><label>User</label><input type="text" value="{{ $transaksi->user->name ?? '-' }}" readonly></div>
            <div class="detail-field"><label>Date</label><input type="text" value="{{ optional($transaksi->created_at)->translatedFormat('d F Y, H.i') }}" readonly></div>
            <div class="detail-field"><label>Method Payment</label><input type="text" value="{{ $transaksi->pembayaran ? ucwords($transaksi->pembayaran->metode) . ($transaksi->pembayaran->detail_metode ? ' (' . $transaksi->pembayaran->detail_metode . ')' : '') : '-' }}" readonly></div>
          </div>

          <!-- KOLOM KANAN FIELD -->
          <div class="item-col">
            <div class="detail-field"><label>Owner</label><input type="text" value="{{ optional(optional($transaksi->barang)->user)->name ?? '-' }}" readonly></div>
            <div class="detail-field"><label>Denda</label><input type="text" value="Rp {{ number_format($transaksi->total_denda ?? 0, 0, ',', '.') }}" readonly></div>
            <div class="detail-field"><label>Status</label><input type="text" value="{{ $transaksi->statusLabel() }}" readonly></div>
          </div>
        </div>

        
        <div id="reviews-section">
          <div class="reviews-header">
            <h3>Receipt</h3>
          </div>

          @php
            $durasi = ($transaksi->tanggal_sewa && $transaksi->tanggal_kembali_rencana)
                ? max(1, \Carbon\Carbon::parse($transaksi->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)))
                : 1;
            $hargaSewa = optional($transaksi->barang)->harga_sewa ?? 0;
            $qty = $transaksi->jumlah ?? 1;
            $subtotal = $hargaSewa * $qty * $durasi;
            $jaminan = (optional($transaksi->barang)->harga_jaminan ?? 0) * $qty;
          @endphp
          <div class="receipt-item">
          <!-- Product -->
          <div class="receipt-product">
            <div class="receipt-product-header">
              <div class="item-badge">{{ $qty }}</div>
              <div class="rec-img">
                <img src="{{ optional($transaksi->barang)->foto_barang ? asset('storage/' . $transaksi->barang->foto_barang) : 'https://placehold.co/200x200?text=No+Image' }}" onerror="this.src='https://placehold.co/200x200?text=No+Image'">
              </div>
              <div class="rec-product-info">
                <div class="rec-product-name">{{ $transaksi->barang->nama_barang ?? '-' }}</div>
                <div class="rec-price">Rp {{ number_format($hargaSewa, 0, ',', '.') }}/hari</div>
              </div>
              <span class="paid-badge">{{ $transaksi->pembayaran ? 'PAID' : 'UNPAID' }}</span>
            </div>

            <!-- Tanggal -->
            <div class="rec-dates">
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Mulai Penyewaan</div>
                <div class="rec-date-val">
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                      style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $transaksi->tanggal_sewa ? $transaksi->tanggal_sewa->translatedFormat('d F Y') : '-' }}</span>
                </div>
              </div>
              <div class="rec-date-item">
                <div class="rec-date-label">Tanggal Selesai Penyewaan</div>
                <div class="rec-date-val">
                  <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                      style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                  </svg>
                  <span>{{ $transaksi->tanggal_kembali_rencana ? $transaksi->tanggal_kembali_rencana->translatedFormat('d F Y') : '-' }}</span>
                </div>
              </div>
            </div>

            <!-- Rows -->
            <div class="rec-rows">
              <div class="rec-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $durasi }} Hari</span></div>
              <div class="rec-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
              <div class="rec-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan, 0, ',', '.') }}</span></div>
              <div class="rec-row total-row"><span class="lbl">Total</span><span class="val">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</span></div>
              <div class="rec-row denda"><span class="lbl">#Catatan Denda</span><span class="val">Rp {{ number_format(optional($transaksi->barang)->harga_denda_perjam ?? 0, 0, ',', '.') }}/jam</span></div>
            </div>
            </div>

          </div>
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
