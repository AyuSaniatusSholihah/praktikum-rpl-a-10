@props(['message' => 'Belum ada barang tersedia'])

<div class="rentals-empty"
     style="grid-column: 1 / -1; text-align: center; padding: 48px 24px;">
    <h3 style="margin: 0 0 8px; font-family: 'Poppins', sans-serif; font-size: 20px; color: #1f2937;">
        {{ $message }}
    </h3>
    <p style="margin: 0; font-family: 'Poppins', sans-serif; font-size: 14px; color: #8A8A8A;">
        Rental akan otomatis mengikuti katalog yang diunggah penyedia.
    </p>
</div>
