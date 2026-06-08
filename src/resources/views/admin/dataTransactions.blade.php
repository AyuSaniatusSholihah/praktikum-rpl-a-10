<x-admin-layout title="Data Transactions - SEWAIN Admin">
<!-- ═══════════════════════════════════════════ -->
    <!-- TRANSACTIONS LIST PAGE -->
    <!-- ═══════════════════════════════════════════ -->
    <section class="page-section" id="page-transactions">
      <div class="page-title">Data Transactions</div>
      <div class="table-card">
        <table class="data-table">
            <table class="data-table table-transactions">
          <thead><tr>
            <th>ID</th><th>User</th><th>Owner</th><th>Item</th><th>Date</th><th>Wallet</th><th>Status</th><th></th>
          </tr></thead>
          <tbody>
            @forelse($transaksis as $trans)
            <tr>
              <td>{{ $trans->formattedId() }}</td>
              <td>{{ $trans->user->name ?? '-' }}</td>
              <td>{{ $trans->barang->user->name ?? '-' }}</td>
              <td>
                <div class="item-info">
                  <img class="item-thumb" src="{{ optional($trans->barang)->foto_barang ? asset('storage/' . $trans->barang->foto_barang) : 'https://placehold.co/60x60?text=No+Image' }}" alt="" onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                  {{ $trans->barang->nama_barang ?? '-' }}
                </div>
              </td>
              <td>
                <div>{{ optional($trans->created_at)->translatedFormat('d M Y') }},</div>
                <div>{{ optional($trans->created_at)->format('H.i') }}</div>
              </td>
              <td>{{ $trans->pembayaran ? ucwords($trans->pembayaran->metode) . ($trans->pembayaran->detail_metode ? ' ' . $trans->pembayaran->detail_metode : '') : '-' }}</td>
              <td><span class="badge {{ $trans->statusBadgeClass() }}">{{ $trans->statusLabel() }}</span></td>
              <td><button class="btn-view" onclick="location.href='{{ route('admin.transactions.detail', $trans->id) }}'">View Details</button></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#727272; padding:24px;">Belum ada transaksi di database.</td></tr>
            @endforelse
          </tbody>
          </table>
        </table>
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
