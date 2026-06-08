<x-layout title="Shopping Cart - SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}" />
    </x-slot:styles>

<section class="cart-page">
  <div class="container">
    <div class="header-section">
      <h1>Shopping Cart</h1>
      <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> &gt; <span>Your Shopping Cart</span></p>
    </div>

    @if($cartItems->isEmpty())
        <div class="table-wrapper" style="display:none;">
    @else
        <div class="table-wrapper">
    @endif

    <table>
    <colgroup>
      <col style="width: 40px">   <!-- checkbox -->
      <col style="width: 40%">    <!-- product -->
      <col style="width: 12%">    <!-- price -->
      <col style="width: 12%">    <!-- quantity -->
      <col style="width: 12%">    <!-- durasi -->
      <col style="width: 12%">    <!-- subtotal -->
      <col style="width: 6%">     <!-- trash -->
    </colgroup>
      <thead>
        <tr>
          <th></th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Durasi Sewa</th>
          <th>SubTotal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($cartItems as $item)
        <tr data-id="{{ $item->id }}">
        <td>
          <input type="checkbox" class="item-check" checked
          data-subtotal="{{ ($item->barang->harga_sewa ?? 0) * $item->jumlah * $item->duration_days }}">
        </td>
          <td>
            <div class="product-info">
              <img src="{{ $item->barang->foto_barang ? asset('storage/' . $item->barang->foto_barang) : 'https://placehold.co/400x300?text=No+Image' }}" alt="{{ $item->barang->nama_barang }}">
              <div class="product-details">
                <p>{{ $item->barang->nama_barang }}</p>
              </div>
            </div>
          </td>
          <td class="price-cell">Rp {{ number_format($item->barang->harga_sewa, 0, ',', '.') }}</td>
          <td class="qty-cell">
            <div class="qty-box">
              <button onclick="updateQty(this, -1)">-</button>
              <input type="text" value="{{ str_pad($item->jumlah, 2, '0', STR_PAD_LEFT) }}" readonly>
              <button onclick="updateQty(this, 1)">+</button>
            </div>
          </td>
          <td class="duration-cell">{{ $item->duration_days }} Hari</td>
          <td>
            <div class="subtotal-wrap">
              <span class="subtotal-cell">Rp {{ number_format(($item->barang->harga_sewa ?? 0) * $item->jumlah * $item->duration_days, 0, ',', '.') }}</span>
              <td>
              <button class="remove-btn" onclick="deleteRow(this)" title="Hapus">
                {{-- icon trash --}}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                  <path d="M10 11v6M14 11v6"/>
                  <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
              </button>
              </td>
            </div>
          </td>
        </tr>
        @empty
        {{-- Jika keranjang kosong, tampilkan pesan kosong --}}
        @endforelse
      </tbody>
    </table>
  </div>


    @if($cartItems->isEmpty())
        <div class="empty-cart" style="display:block;">
    @else
        <div class="empty-cart">
    @endif
        <p>Keranjang kamu kosong 🛒</p>
        <a href="{{ route('rentals') }}">Lihat Produk</a>
    </div>


    @if(!$cartItems->isEmpty())
    <div class="checkout-container">
      <div class="checkout-box">
        <label class="wrap-option">
          <input type="checkbox">
          <span>For <span class="wrap-price">$10.00</span> Please Wrap The Product</span>
        </label>


        <div class="summary-row">
            <p class="label"  style="font-family:'Volkhov',serif; color:var(--black);">Subtotal</p>
            <strong class="amount">Rp {{ number_format($cartTotal, 0, ',', '.') }}</strong>
        </div>
        <div class="action-group">
            <a href="{{ route('checkout') }}" class="btn-checkout" onclick="return goCheckout()">Checkout</a>
            <button class="view-cart-link">View Cart</button>
        </div>
      </div>
    </div>
    @endif
  </div>
</section>

<x-slot:scripts>
  <script>
    function updateSubtotal() {
      let total = 0;
      document.querySelectorAll('tbody tr').forEach(row => {
        const checkbox = row.querySelector('.item-check');
        if (checkbox && checkbox.checked) {
          const subtotalText = row.querySelector('.subtotal-cell').textContent;
          const angka = parseInt(subtotalText.replace(/[^0-9]/g, ''));
          total += angka;
        }
      });
      // update tampilan subtotal
      document.querySelector('.summary-row .amount').textContent =
        'Rp ' + total.toLocaleString('id-ID');
    }


    // panggil saat checkbox diubah
    document.addEventListener('change', function(e) {
      if (e.target.classList.contains('item-check')) {
        updateSubtotal();
      }
    });


    function deleteRow(btn) {
    const row = btn.closest('tr');
    const itemId = row.dataset.id; // perlu tambah data-id di <tr>
    const qtyInput = row.querySelector('.qty-box input');
    const itemQty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
   
    fetch(`/cart/${itemId}`, {
        method: 'DELETE',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => {
        row.remove();
        updateSubtotal();
        
        const cartBadge = document.getElementById('cartBadge');
        if (cartBadge) {
            let count = parseInt(cartBadge.textContent) || 0;
            let newCount = count - itemQty;
            cartBadge.textContent = newCount > 0 ? newCount : 0;
        }

        if (document.querySelectorAll('tbody tr').length === 0) {
        document.querySelector('.table-wrapper').style.display = 'none';
        document.querySelector('.checkout-container')?.style &&
            (document.querySelector('.checkout-container').style.display = 'none');
        document.querySelector('.empty-cart').style.display = 'block';
        }
    });
    }


    function updateQty(btn, change) {
    const row = btn.closest('tr');
    const itemId = row.dataset.id;
    let input = btn.parentElement.querySelector('input');
    let current = parseInt(input.value);
    let newVal = current + change;
   
    if (newVal > 0) {
        input.value = newVal < 10 ? '0' + newVal : newVal;
       
        // simpan ke database
        fetch(`/cart/${itemId}/quantity`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newVal })
        }).then(res => {
            if (!res.ok) {
                return res.json().then(err => { throw err; });
            }
            return res.json();
        })
        .then(data => {
            // update subtotal baris ini
            const subtotalCell = row.querySelector('.subtotal-cell');
            subtotalCell.textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
            updateSubtotal();
            
            // update header badge
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                let count = parseInt(cartBadge.textContent) || 0;
                let newCount = count + change;
                cartBadge.textContent = newCount > 0 ? newCount : 0;
            }
        })
        .catch(err => {
            alert(err.error || 'Terjadi kesalahan saat memperbarui kuantitas.');
            // Revert back to the old value
            input.value = current < 10 ? '0' + current : current;
        });
    }
    }


    function goCheckout() {
      const checked = document.querySelectorAll('.item-check:checked');
      if (checked.length === 0) {
        alert('Pilih minimal 1 item untuk checkout!');
        return false;
      }
      return true;
    }
    </script>
</x-slot:scripts>
</x-layout>
