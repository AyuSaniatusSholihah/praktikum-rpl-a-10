<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiPengembalianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_kondisi' => 'required|in:ok,tolak',
            'denda_kerusakan' => 'required_if:status_kondisi,tolak|numeric|min:0'
        ];
    }
}
