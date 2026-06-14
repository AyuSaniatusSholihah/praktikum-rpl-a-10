<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class BayarMassalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaksi_ids' => 'required|array',
            'transaksi_ids.*' => 'integer|exists:transaksi_penyewaans,id',
            'metode' => 'required|in:transfer bank,e-wallet,qris',
            'detail_metode' => 'required|string|max:50', // Contoh: BCA, Mandiri, ShopeePay, Gopay
        ];
    }
}
