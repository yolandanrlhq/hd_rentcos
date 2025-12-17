<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sewa;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    public function create(Sewa $sewa)
    {
        // pastikan hanya user pemilik
        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.testimoni', compact('sewa'));
    }

    public function store(Request $request, Sewa $sewa)
    {
        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'isi'    => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if ($sewa->testimoni) {
            return back()->with('error', 'Testimoni sudah ada.');
        }

        // 🔥 AMBIL PRODUK DARI SEWA_ITEMS
        $sewaItem = $sewa->items()->first();

        if (!$sewaItem) {
            return back()->with('error', 'Produk sewa tidak ditemukan.');
        }

        Testimoni::create([
            'sewa_id'   => $sewa->id,
            'produk_id' => $sewaItem->produk_id, // ✅ BENAR SEKARANG
            'user_id'   => Auth::id(),
            'isi'       => $request->isi,
            'rating'    => $request->rating
        ]);

        return redirect()
            ->route('cart.status', ['status' => 'selesai'])
            ->with('success', 'Testimoni berhasil dikirim!');
    }
}
