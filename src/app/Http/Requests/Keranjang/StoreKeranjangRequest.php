<?php

namespace App\Http\Requests\Keranjang;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeranjangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorize is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_sewa',
        ];
    }
}
