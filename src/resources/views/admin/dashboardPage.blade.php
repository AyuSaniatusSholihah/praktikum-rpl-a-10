<x-admin-layout title="Dashboard - SEWAIN Admin">
<!-- Stat Cards -->
    <div class="stat-cards">
      <x-admin-stat-card label="Total User" value="{{ $stats['total_user'] }}" changeText="Total user terdaftar" iconClass="icon-blue">
        <svg width="32" height="24" viewBox="0 0 32 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path opacity="0.587821" d="M24.001 6.66699C26.2101 6.66699 28.001 8.45785 28.001 10.667C28.0008 12.876 26.21 14.667 24.001 14.667C21.7921 14.6668 20.0012 12.8759 20.001 10.667C20.001 8.45796 21.792 6.66717 24.001 6.66699ZM12.001 0C14.9464 0 17.3348 2.38764 17.335 5.33301C17.335 8.27853 14.9465 10.667 12.001 10.667C9.05561 10.6668 6.66797 8.27842 6.66797 5.33301C6.66814 2.38775 9.05572 0.000175999 12.001 0Z" fill="#2485A8"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9774 13.3335C18.3611 13.3335 23.6061 16.391 23.997 22.9331C24.0125 23.1937 23.9966 24.0005 22.995 24.0005H0.969619C0.635144 24.0001 -0.0272745 23.2787 0.000869049 22.9321C0.517816 16.5688 5.68241 13.3336 11.9774 13.3335ZM23.4686 16.0024C28.0103 16.0523 31.7187 18.3471 31.9979 23.1997C32.0092 23.3952 31.9977 24.0005 31.2743 24.0005H26.1337C26.1337 20.9998 25.1416 18.2305 23.4686 16.0024Z" fill="#2485A8"/>
        </svg>
      </x-admin-stat-card>

      <x-admin-stat-card label="Total Owner" value="{{ $stats['total_owner'] }}" changeText="User yang punya katalog" iconClass="icon-green">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3.11111 24.8889H26.4444C27.3036 24.8889 28 25.5853 28 26.4444C28 27.3036 27.3036 28 26.4444 28H1.55556C0.696446 28 0 27.3036 0 26.4444V1.55556C0 0.696446 0.696446 0 1.55556 0C2.41467 0 3.11111 0.696446 3.11111 1.55556V24.8889Z" fill="#0D894B"/>
          <path opacity="0.5" d="M8.91305 18.175C8.32547 18.8017 7.34106 18.8335 6.71431 18.2459C6.08756 17.6583 6.0558 16.6739 6.64338 16.0472L12.4767 9.82494C13.045 9.21879 13.9893 9.16623 14.6213 9.70555L19.2253 13.6343L25.224 6.03606C25.7563 5.36176 26.7345 5.24668 27.4088 5.77903C28.0831 6.31137 28.1982 7.28955 27.6658 7.96385L20.6658 16.8305C20.1191 17.5231 19.1063 17.6227 18.4351 17.0499L13.7311 13.0358L8.91305 18.175Z" fill="#0D894B"/>
        </svg>
      </x-admin-stat-card>

      <x-admin-stat-card label="Total Rent" value="{{ $stats['total_rent'] }}" changeText="Total transaksi penyewaan" iconClass="icon-amber">
        <svg width="30" height="34" viewBox="0 0 30 34" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.3167L12.9005 18.7648C13.0394 18.845 13.1851 18.9029 13.3333 18.9397V33.3849L0.920065 26.0387C0.349784 25.7012 0 25.0878 0 24.4251V11.3167ZM30 11.1187V24.4251C30 25.0878 29.6502 25.7012 29.0799 26.0387L16.6667 33.3849V18.8131C16.6969 18.798 16.7269 18.7819 16.7566 18.7648L30 11.1187Z" fill="#D09403"/>
          <path opacity="0.499209" fill-rule="evenodd" clip-rule="evenodd" d="M0.40625 7.70142C0.563825 7.50244 0.762713 7.33426 0.994592 7.21076L14.1196 0.2201C14.6706 -0.0733665 15.3315 -0.0733665 15.8825 0.2201L29.0075 7.21076C29.1862 7.30596 29.3454 7.42771 29.4811 7.56966L15.0909 15.8778C14.9963 15.9325 14.9091 15.995 14.8296 16.064C14.75 15.995 14.6628 15.9325 14.5682 15.8778L0.40625 7.70142Z" fill="#D09403"/>
        </svg>
      </x-admin-stat-card>
    </div>

    <!-- Financial Wallet Preview -->
    <div class="section-header">
      <h3>Financial Wallet</h3>
      <a href="{{ route('admin.financial-wallet') }}">See All</a>
    </div>
    <div class="wallet-cards-grid">
      <div class="wallet-card">
        <div class="wc-icon">
          <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <rect width="34.7713" height="34.7713" fill="url(#pattern0_3428_8106)"/>
          <defs>
          <pattern id="pattern0_3428_8106" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_3428_8106" transform="scale(0.01)"/>
          </pattern>
          <image id="image0_3428_8106" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAABmJLR0QA/wD/AP+gvaeTAAAHd0lEQVR4nO2dX4wdVR3HP79pBaEt+KIY1iItDUWFUrbBiMYY/INNwBeLhXR9MtE+iBEDrX+CCTTEID7oK2hijdRsDCiGuLggiwmmaqK7pYlVGymQtVDQoNi1he22Xx/O3JvZs9P9c+/MOSfZ83k7c+/8ft853ztzz5wzcw5kMplMJpPJZDKZTFis1x0lrQAGgeuBLcDlwFrgfOC8RtSlz0ngBDAJ/A0YB8aACTM73UvAJRsi6TJgJzAEXNxL0mXAUWAf8ICZHVnKjos2RNKlwL3ArcCKJclbvswAw8BdZvbiYnZY0JDy0rQL+CbucpRZOieAPcB3zOzMfF+c1xBJFwE/AT7anLZlza+BITN79WxfOKshktYBTwAbWhC2nHke2Gpmh+s+rDVE0gbgGeCdLQpbzhwDPmxmf/c/mGNIeZn6HbAugLDlzBHgOv/yVVQLkgrgx2QzQrAeGC4bTV0K70u7gU8Ek5S5HrijuqF7yZJ0CXAIWBVY1HLnBPA+M3sBZp8h3yKbEYPzgXs6hQK63SG39BhwBFhrCwCsBq4AdgA/Bab7Oox2mcZp3IHTvBrXT/d4S/l2SFrfLUm6X73zrl4USLpM0s/6yNsWj6haObM1r20x732dJCskHe0jUE+GVA5yt6TTjRxSf5yWtGsBrW0aMimpQNK1fQYakbS2AVNisxgzHm9Zw5aQlTEl6feSbpN0Ts0B/zyQjjoeqdFzrqQvlZqnAunYZZKG6f0PvVcOADeZ2dFKBWzANbvfEljLNPCe6riFpAHgl8DVgbUMF7hWRGg2A4+pcqaU/Tq/iKDlUc+Mc4ljBsDGgnijftcAn/e2PRpBh59zJ3HMABgocG3sWHzWK/8xgoY/eeWhCBo6rDFJiijguJld0ClIWgP8N7CGC8zseEXDcSL+SP3OxdD4P4Z5hzdbYiZCzrMS25A/e+UYA2J+Tl9TUGIb8pBXvjaCBj/nvggausQ0ZBz4gbdtWwQdn/bKD+Luk6IQ6099HPiUmb3U2SDXofcXYM5dfMtMAxs74xGllgHgMVzTPCghz5Ap3Fj9F3FjyVUzDPgu4c2gzPm96oayB+EDwG04zVMRdMVD0tcC9RXNx+7Y9RAdSSbpG7GdKDkj6etyZ+vyQ9IVar87uxdGJG2MVS/Rfg2STgErY+VfgBkzC93rDARsZZXj6l1C5e2VWHpj3xhmPLIhiZENSYxsSGJkQxIjG5IY2ZDEyIYkRjYkMbIhiZENSYxsSGJkQxIjG5IY2ZDEyIYkRjYkMbIhiZENSYyV/thxQA4B742UeyEO+RtC1VPMM+RK3LwqoxE1+IziNF0ZW0hUJH1G0r9iPYgl6d+SvhC7HpJC0sWSJiKYMSEpmdlVQz79/gZu+tT9uHlERvwJISW9DTd3ynWBNO0HbjSz/3g6CuBGYDvwQdyLsW8NISjmO4YHgc+Z2ayXLiWtxlXUVQHyf8jMZj3ZLmkL8MMA+WuJ+ae+Cdgvb0qLsoK2Aa+3mPt1YFuNGV/FvX4QxYyOiBTYU6Prlhbzba/Jd2+L+RZNKoZI0u01lTTWQp6navJ8pYU8PRH7PfUq08D7zezZzgZJV+Ne7G9qavPTwKCZHazk2Az8gThvb80hpa6Tc4C9qszSWZrT5CxuI54ZK4G9JGIGOEPeiC2iwmbgZm/b9xuM/6BX3k68eU3qOGmSXgXeHltJhXEz29IplL/iSfqfVOBl3NyQ3XU9JI0T4U3beXilwN2spcSgpG4lmdkM8JsG4j7tmTFIWmYAvFTgVoZJjRu88m8biPmMV97aQMym+WuBe4k/NT7mlZuYtsk/zhSX4BgvgKdjq6jhUq/8SgMxjy2QIwXGrGxmvggMxFZTwZ9HaxX9z6awysxOVGJGnRerhn8A7y7KP7qoM+Asgp5WPGshRps8ZGZnOjeGD5DWRF4ve+ULG4jpx/AvYTGZobxHKgDKWTmHYyryeMErN3G992P4OWKyz8yeh9ldJ3fhlk5IgTGv3MQYtx/DzxGL/+FWwAMqhpTr7N1Tt0cE/AcfPtJATD/GrxqI2QR3m9lkp+BPH1HgKuPjoVVV8LtOVuB6Ey7qM+4xYKA6bJxA18mTuBXbuppm9faWHwwBzwUWVuV+r3wD/ZsBri/M7wHwc4XkOdyahrOeK5jT/V6uGraVOK2QCeBhb9vOBuP7sR4mzvyKx4BPmtk/F72HpHWSDgccLHtT0iZPw1Vqdm2RM3IDUtUcm8rcoTgi6fKebJT0DklPBhL65Zr8oy3kmTPgJen2FvLU8YSk/oY6JBVya4y0uYbG3TV5h1rMt6Mm354W801JulOu0dQMki6R9CNJpxoU+qakO2pybZD0WoN5fF6TWwjNz3unmr18nZK0V32uQLSQMeslfVtuzaR+mFBlIKoS/0JJB/uMvRielTSnS0bSoKQDfcaelHSf3ALPS6LnR+zlTr9rcOMKg8BGXI/xGuC8ml1O4no09+O6aUbNbNYTL3KrI4wS9lHSrdXVEUodhmtp3op7lHSAsx/TcdxxHcY9ITMGHFho3fRMJpPJZDKZTCaTSYX/A3Zi8DuSk2kyAAAAAElFTkSuQmCC"/>
          </defs>
        </svg>
        </div>
        <div class="wc-total-label">Total Transaction Sewa User</div>
        <div class="wc-amount">Rp {{ number_format($walletByMethod['transfer bank'], 0, ',', '.') }}</div>
        <div class="wc-row"><span>CARD HOLDER</span><span>PAYMENT METHOD</span></div>
          <div class="wc-row">
            <span class="wc-name">SEWAIN</span>
            <span class="wc-method">BANK TRANSFER</span>
          </div>

          <div class="wc-bottom">
        <div class="wc-number">0978 5634 21196</div>
        </div>
      </div>
      <div class="wallet-card">
        <div class="wc-icon">
          <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <rect width="34.7713" height="34.7713" fill="url(#pattern0_3428_8106)"/>
          <defs>
          <pattern id="pattern0_3428_8106" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_3428_8106" transform="scale(0.01)"/>
          </pattern>
          <image id="image0_3428_8106" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
          </defs>
        </svg>
        </div>
        <div class="wc-total-label">Total Transaction Sewa User</div>
        <div class="wc-amount">Rp {{ number_format($walletByMethod['e-wallet'], 0, ',', '.') }}</div>
        <div class="wc-row"><span>CARD HOLDER</span><span>PAYMENT METHOD</span></div>
          <div class="wc-row">
            <span class="wc-name">SEWAIN</span>
            <span class="wc-method">E-WALLET</span>
          </div>
          <div class="wc-bottom">
        <div class="wc-number">0858 4619 7216</div>
        </div>
      </div>
      <div class="wallet-card">
        <div class="wc-icon">
        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Kotak kiri atas -->
          <rect x="2" y="2" width="13" height="13" rx="1.5" stroke="white" stroke-width="1.8" fill="none"/>
          <rect x="5" y="5" width="7" height="7" rx="0.5" fill="white"/>
          <!-- Kotak kanan atas -->
          <rect x="23" y="2" width="13" height="13" rx="1.5" stroke="white" stroke-width="1.8" fill="none"/>
          <rect x="26" y="5" width="7" height="7" rx="0.5" fill="white"/>
          <!-- Kotak kiri bawah -->
          <rect x="2" y="23" width="13" height="13" rx="1.5" stroke="white" stroke-width="1.8" fill="none"/>
          <rect x="5" y="26" width="7" height="7" rx="0.5" fill="white"/>
          <!-- Dot pattern kanan bawah -->
          <rect x="23" y="23" width="3" height="3" fill="white"/>
          <rect x="28" y="23" width="3" height="3" fill="white"/>
          <rect x="33" y="23" width="3" height="3" fill="white"/>
          <rect x="23" y="28" width="3" height="3" fill="white"/>
          <rect x="28" y="28" width="3" height="3" fill="white"/>
          <rect x="33" y="28" width="3" height="3" fill="white"/>
          <rect x="23" y="33" width="3" height="3" fill="white"/>
          <rect x="33" y="33" width="3" height="3" fill="white"/>
          <!-- Garis tengah -->
          <rect x="17" y="2" width="3" height="3" fill="white"/>
          <rect x="17" y="7" width="3" height="3" fill="white"/>
          <rect x="17" y="12" width="3" height="3" fill="white"/>
          <rect x="2" y="17" width="3" height="3" fill="white"/>
          <rect x="7" y="17" width="3" height="3" fill="white"/>
          <rect x="12" y="17" width="3" height="3" fill="white"/>
          <rect x="17" y="17" width="3" height="3" fill="white"/>
          <rect x="23" y="17" width="3" height="3" fill="white"/>
          <rect x="28" y="17" width="3" height="3" fill="white"/>
          <rect x="33" y="17" width="3" height="3" fill="white"/>
        </svg>
        </div>
        <div class="wc-total-label">Total Transaction Sewa User</div>
        <div class="wc-amount">Rp {{ number_format($walletByMethod['qris'], 0, ',', '.') }}</div>
        <div class="wc-row"><span>CARD HOLDER</span><span>PAYMENT METHOD</span></div>
          <div class="wc-row">
            <span class="wc-name">SEWAIN</span>
            <span class="wc-method">QRIS</span>
          </div>
      </div>
    </div>

    <!-- Data User Preview -->
    <div class="section-header">
      <h3>Data User</h3>
      <a href="{{ route('admin.users') }}">See All</a>
    </div>
    <div class="users-grid" style="margin-bottom:24px;">
      @forelse($usersPreview as $u)
      <div class="user-card">
        <img src="{{ $u->foto_profil ? asset('storage/' . $u->foto_profil) : asset('assets/img/default-avatar.svg') }}" alt="{{ $u->name }}" onerror="this.src='{{ asset('assets/img/default-avatar.svg') }}'">
        <div class="user-card-info">
          <h4>{{ $u->name }}</h4>
          <p>{{ $u->email }}</p>
          <button class="btn-view-more" onclick="location.href='{{ route('admin.users.detail', $u->id) }}'">View More</button>
        </div>
      </div>
      @empty
        <p style="grid-column:1/-1; color:#727272;">Belum ada user.</p>
      @endforelse
    </div>

    <!-- Data Items Preview -->
    <div class="section-header">
      <h3>Data Items</h3>
      <a href="{{ route('admin.items') }}">See All</a>
    </div>
    <div class="table-card">
      <table class="data-table">
        <thead><tr>
          <th>ID</th><th>Name</th><th>Owner</th><th>Price</th><th>Category</th><th>Status</th><th></th>
        </tr></thead>
          <tbody>
            @forelse($itemsPreview as $item)
            <tr>
              <td>{{ $item->formattedId() }}</td>
              <td><div class="item-info"><img class="item-thumb" src="{{ $item->foto_barang ? asset('storage/' . $item->foto_barang) : 'https://placehold.co/60x60?text=No+Image' }}" alt="" onerror="this.src='https://placehold.co/60x60?text=No+Image'">{{ $item->nama_barang }}</div></td>
              <td>{{ $item->user->name ?? '-' }}</td>
              <td>Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}/hari</td>
              <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
              <td><span class="badge {{ $item->statusBadgeClass() }}">{{ $item->statusLabel() }}</span></td>
              <td><button class="btn-view" onclick="location.href='{{ route('admin.items.detail', $item->id) }}'">View Details</button></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#727272; padding:16px;">Belum ada item.</td></tr>
            @endforelse
          </tbody>
      </table>
    </div>

    <!-- Data Transactions Preview -->
    <div class="section-header">
      <h3>Data Transactions</h3>
      <a href="{{ route('admin.transactions') }}">See All</a>
    </div>
    <div class="table-card">
      <table class="data-table">
        <thead><tr>
          <th>ID</th><th>User</th><th>Owner</th><th>Item</th><th>Date</th><th>Wallet</th><th>Status</th><th>Receipt</th>
        </tr></thead>
        <tbody>
          @forelse($transaksiPreview as $trans)
          <tr>
            <td>{{ $trans->formattedId() }}</td><td>{{ $trans->user->name ?? '-' }}</td><td>{{ $trans->barang->user->name ?? '-' }}</td>
            <td><div class="item-info"><img class="item-thumb" src="{{ optional($trans->barang)->foto_barang ? asset('storage/' . $trans->barang->foto_barang) : 'https://placehold.co/60x60?text=No+Image' }}" alt="" onerror="this.src='https://placehold.co/60x60?text=No+Image'">{{ $trans->barang->nama_barang ?? '-' }}</div></td>
            <td>{{ optional($trans->created_at)->translatedFormat('d M Y, H.i') }}</td><td>{{ $trans->pembayaran ? ucwords($trans->pembayaran->metode) : '-' }}</td>
            <td><span class="badge {{ $trans->statusBadgeClass() }}">{{ $trans->statusLabel() }}</span></td>
            <td><button class="btn-view" onclick="location.href='{{ route('admin.transactions.detail', $trans->id) }}'">View Details</button></td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center; color:#727272; padding:16px;">Belum ada transaksi.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

</x-admin-layout>
