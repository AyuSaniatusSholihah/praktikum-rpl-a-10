<?php

namespace App\Http\Requests\Keranjang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKeranjangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jumlah' => 'sometimes|integer|min:1',
            'tanggal_sewa' => 'sometimes|date',
            'tanggal_kembali_rencana' => 'sometimes|date',
        ];
    }
}
