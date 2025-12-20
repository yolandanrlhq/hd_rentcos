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
        // 🔐 Pastikan hanya pemilik pesanan
        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        // 🔒 Hanya boleh jika SEWA selesai
        if ($sewa->status !== 'selesai') {
            return redirect()
                ->route('cart.status')
                ->with('error', 'Pesanan belum selesai.');
        }

        return view('user.testimoni', compact('sewa'));
    }

    public function store(Request $request, Sewa $sewa)
    {
        // 🔐 Pastikan hanya pemilik
        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        // 🔒 Pastikan status sewa selesai
        if ($sewa->status !== 'selesai') {
            return back()->with('error', 'Pesanan belum selesai.');
        }

        // ❌ Cegah double testimoni
        if ($sewa->testimoni) {
            return back()->with('error', 'Testimoni sudah ada.');
        }

        $request->validate([
            'isi'    => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'foto'   => 'nullable|image|max:2048',
        ]);

        // 🔥 Ambil produk dari sewa_items
        $sewaItem = $sewa->items()->first();

        if (!$sewaItem) {
            return back()->with('error', 'Produk sewa tidak ditemukan.');
        }

        // 📸 Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('testimoni', 'public');
        }

        Testimoni::create([
            'sewa_id'   => $sewa->id,
            'produk_id' => $sewaItem->produk_id,
            'isi'       => $request->isi,
            'rating'    => $request->rating,
            'foto'      => $fotoPath,
        ]);

        return redirect()
            ->route('cart.status', ['status' => 'selesai'])
            ->with('success', 'Testimoni berhasil dikirim!');
    }

    public function show(Sewa $sewa)
    {
        // 🔐 hanya pemilik sewa
        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        // ❌ kalau belum ada testimoni
        if (!$sewa->testimoni) {
            abort(404);
        }

        return view('user.testimoniShow', [
            'sewa' => $sewa,
            'testimoni' => $sewa->testimoni
        ]);
    }
}
