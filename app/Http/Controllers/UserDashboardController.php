<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\Event; // ⬅️ tambah ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        // ================= PRODUK REKOMENDASI =================
        $rekomendasi = DB::table('produk')
            ->select('produk.*', DB::raw('SUM(sewa_items.jumlah) as total_sewa'))
            ->join('sewa_items', 'produk.id_produk', '=', 'sewa_items.produk_id')
            ->join('sewa', 'sewa.id', '=', 'sewa_items.sewa_id')
            ->whereIn('sewa.status', ['selesai', 'dikirim'])
            ->groupBy('produk.id_produk')
            ->orderByDesc('total_sewa')
            ->take(5)
            ->get();

        // ================= PRODUK TERBARU =================
        $latest = Produk::orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        // ================= TESTIMONI =================
        $testimoni = Testimoni::where('rating', '>=', 4)
                            ->orderBy('rating', 'desc')
                            ->take(5)
                            ->get();

        // ================= EVENT PREVIEW =================
        $eventHighlight = Event::orderBy('tgl_event', 'desc')
                    ->orderBy('tgl_event', 'asc')
                    ->first();


        return view('user.dashboard', compact(
            'rekomendasi',
            'latest',
            'testimoni',
            'eventHighlight'
        ));
    }
}
