<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Produk rekomendasi berdasarkan rating tertinggi
        $rekomendasi = DB::table('produk')
            ->select('produk.*', DB::raw('SUM(sewa_items.jumlah) as total_sewa'))
            ->join('sewa_items', 'produk.id_produk', '=', 'sewa_items.produk_id')
            ->join('sewa', 'sewa.id', '=', 'sewa_items.sewa_id')
            ->whereIn('sewa.status', ['selesai', 'dikirim']) // hanya sewa valid
            ->groupBy('produk.id_produk')
            ->orderByDesc('total_sewa')
            ->take(5)
            ->get();

        // Produk terbaru
        $latest = Produk::orderBy('created_at', 'desc')->take(5)->get();

        // Testimoni: review dengan rating >= 4
        // Jika kamu punya model Review / Ulasan
        $testimoni = Testimoni::where('rating', '>=', 4)
                            ->orderBy('rating', 'desc')
                            ->take(5)
                            ->get();

        return view('user.dashboard', compact('rekomendasi', 'latest', 'testimoni'));
    }
}
