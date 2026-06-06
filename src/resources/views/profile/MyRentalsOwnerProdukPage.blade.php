@php
    $barang  = $trx->barang;
    $foto    = $barang && $barang->foto_barang ? asset('storage/' . $barang->foto_barang) : asset('assets/img/default-avatar.svg');
    $durasi  = ($trx->tanggal_sewa && $trx->tanggal_kembali_rencana)
        ? max(1, $trx->tanggal_sewa->diffInDays($trx->tanggal_kembali_rencana))
        : 1;
    $hargaSewa = $barang->harga_sewa ?? 0;
    $jumlah    = $trx->jumlah ?? 1;
    $subtotal  = $hargaSewa * $jumlah * $durasi;
    $statusBadge = [
        'aktif' => 'Active Rent', 'upcoming' => 'UpComing Rent', 'diproses' => 'Diproses',
        'selesai' => 'Selesai', 'pengembalian' => 'Return Rent',
    ][$trx->status] ?? ucfirst($trx->status);
@endphp

<x-profile-layout active="owner" pageTitle="Rentals Owner">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </x-slot:styles>

    <div class="welcome-section">
        <h2 class="section-title">My Rentals Owner</h2>
        <p class="section-subtitle">Detail penyewaan barang Anda</p>
    </div>

    <div class="detail-head">
        <img class="detail-img" src="{{ $foto }}" alt="{{ $barang->nama_barang ?? 'Barang' }}">
        <h3 class="detail-title">{{ $barang->nama_barang ?? 'Barang dihapus' }}</h3>
    </div>

    <div class="detail-form-grid">
        <div class="form-group">
            <label>ID Transaction</label>
            <input type="text" value="T{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}" readonly>
        </div>
        <div class="form-group">
            <label>Owner</label>
            <input type="text" value="{{ $user->name }}" readonly>
        </div>
        <div class="form-group">
            <label>Penyewa</label>
            <input type="text" value="{{ $trx->user->name ?? '-' }}" readonly>
        </div>
        <div class="form-group">
            <label>Denda</label>
            <input type="text" value="Rp {{ number_format($trx->total_denda ?? 0, 0, ',', '.') }}" readonly>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="text" value="{{ optional($trx->created_at)->format('d M Y, H.i') }}" readonly>
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text" value="{{ $statusBadge }}" readonly>
        </div>
    </div>

    <h3 class="section-divider-title">Receipt</h3>
    <div class="receipt-card">
        <div class="receipt-head">
            <img class="receipt-img" src="{{ $foto }}" alt="{{ $barang->nama_barang ?? 'Barang' }}">
            <div>
                <div class="receipt-prodname">{{ $barang->nama_barang ?? 'Barang dihapus' }}</div>
                <div class="receipt-perday">Rp {{ number_format($hargaSewa, 0, ',', '.') }}/hari</div>
                <div class="receipt-dates">
                    <div>
                        <div class="lbl">Tanggal Mulai Penyewaan</div>
                        <div class="val"><i class="fa-regular fa-calendar"></i> {{ optional($trx->tanggal_sewa)->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="lbl">Tanggal Selesai Penyewaan</div>
                        <div class="val"><i class="fa-regular fa-calendar"></i> {{ optional($trx->tanggal_kembali_rencana)->format('d M Y') ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <span class="paid-badge">{{ $trx->pembayaran ? 'PAID' : 'UNPAID' }}</span>
        </div>

        <div class="receipt-rows">
            <div class="receipt-row"><span>Durasi Sewa</span><span>{{ $durasi }} Hari</span></div>
            <div class="receipt-row"><span>Subtotal ({{ $jumlah }} x {{ $durasi }} hari)</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
            <div class="receipt-row"><span>Jaminan</span><span>Rp {{ number_format($barang->harga_jaminan ?? 0, 0, ',', '.') }}</span></div>
            <div class="receipt-row total"><span>Total</span><span>Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</span></div>
            <div class="receipt-row note"><span>#Catatan Denda Pengembalian</span><span>Rp {{ number_format($barang->harga_denda_perjam ?? 0, 0, ',', '.') }}/jam</span></div>
        </div>
    </div>

</x-profile-layout>
