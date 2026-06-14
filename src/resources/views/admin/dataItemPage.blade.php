<x-admin-layout title="Data Items - SEWAIN Admin" headerTitle="Data Items" scrollable>
<!-- ═══════════════════════════════════════════ -->
    <!-- ITEMS LIST PAGE -->
    <!-- ═══════════════════════════════════════════ -->
      <div class="table-card">
        <table class="data-table">
          <thead><tr>
            <th>ID</th><th>Name</th><th>Owner</th><th>Price</th><th>Category</th><th>Status</th><th></th><th></th>
          </tr></thead>
          <tbody>
            @forelse($items as $item)
            <tr>
              <td>{{ $item->formattedId() }}</td>
              <td>
                <div class="item-info">
                  <img class="item-thumb" src="{{ $item->foto_barang ? asset('storage/' . $item->foto_barang) : 'https://placehold.co/60x60?text=No+Image' }}" alt="" onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                  {{ $item->nama_barang }}
                </div>
              </td>
              <td>{{ $item->user->name ?? '-' }}</td>
              <td>Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}/hari</td>
              <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
              <td><span class="badge {{ $item->statusBadgeClass() }}">{{ $item->statusLabel() }}</span></td>
              <td><button class="btn-view" onclick="location.href='{{ route('admin.items.detail', $item->id) }}'">View Details</button></td>
              <td>
                <form id="form-delete-{{ $item->id }}" action="{{ route('admin.items.delete', $item->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn-delete" title="Buang item" onclick="showAdminConfirm('Buang Item', 'Yakin ingin membuang item ini dari katalog?', 'form-delete-{{ $item->id }}')">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.5312 3.23438H13.6562V1.4375C13.6562 0.644629 13.0116 0 12.2188 0H5.03125C4.23838 0 3.59375 0.644629 3.59375 1.4375V3.23438H0.71875C0.321191 3.23438 0 3.55557 0 3.95312V4.67188C0 4.7707 0.0808594 4.85156 0.179688 4.85156H1.53633L2.09111 16.5986C2.12705 17.3646 2.76045 17.9688 3.52637 17.9688H13.7236C14.4918 17.9688 15.1229 17.3668 15.1589 16.5986L15.7137 4.85156H17.0703C17.1691 4.85156 17.25 4.7707 17.25 4.67188V3.95312C17.25 3.55557 16.9288 3.23438 16.5312 3.23438ZM12.0391 3.23438H5.21094V1.61719H12.0391V3.23438Z" fill="#6A87A1"/>
                    </svg>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#727272; padding:24px;">Belum ada item di database.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>


<x-slot:scripts>
<script>
function showItemDetail() {
    location.href = '{{ route('admin.items') }}';
  }

  function showUserDetail(id) {
    location.href = '/admin/users/' + id;
  }
</script>
</x-slot:scripts>
</x-admin-layout>
