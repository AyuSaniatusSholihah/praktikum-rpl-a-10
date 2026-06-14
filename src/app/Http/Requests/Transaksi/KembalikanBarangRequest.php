<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class KembalikanBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto_buktipengembalian' => 'required|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ];
    }
}
