<?php

namespace App\Http\Controllers;

use App\Models\WebReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebReviewController extends Controller
{
    /** Form ulasan tentang website SEWAIN (hanya user login). */
    public function create()
    {
        return view('reviewweb', ['user' => Auth::user()]);
    }

    /** Simpan ulasan website ke database. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Silakan beri rating bintang terlebih dahulu.',
            'rating.min'      => 'Silakan beri rating bintang terlebih dahulu.',
            'ulasan.required' => 'Ulasan tidak boleh kosong.',
        ]);

        WebReview::create([
            'user_id' => Auth::id(),
            'rating'  => $validated['rating'],
            'ulasan'  => $validated['ulasan'],
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Terima kasih! Ulasanmu tentang SEWAIN sudah terkirim.');
    }
}
