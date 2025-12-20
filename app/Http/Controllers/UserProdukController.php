<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProdukController extends Controller
{
    /**
     * Halaman list produk (user)
     */
    public function index(Request $request)
    {
        $query = Produk::withAvg('testimonis', 'rating')
            ->withCount('testimonis');

        // SEARCH
        if ($request->filled('q')) {
            $query->where('nama_produk', 'LIKE', '%' . $request->q . '%');
        }

        // FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $produks = $query->get();

        return view('user.produk', compact('produks'));
    }

    /**
     * Halaman detail produk
     */
    public function show($id)
    {
        $produk = Produk::with([
                'ukuran',
                'testimonis' => function ($q) {
                    $q->latest();
                }
            ])
            ->withAvg('testimonis', 'rating')
            ->withCount('testimonis')
            ->where('id_produk', $id)
            ->firstOrFail();

        /**
         * =======================
         * LOGIC STOK PER UKURAN
         * =======================
         */
        $ukuranCollection = $produk->ukuran;

        $ukuranList = ['S', 'M', 'L', 'XL', 'All Size'];
        $stok = [];

        foreach ($ukuranList as $uk) {
            $ukuranData = $ukuranCollection->firstWhere('nama_ukuran', $uk);

            if ($ukuranData) {
                $stok[$uk] = [
                    'stok'      => $ukuranData->stok,
                    'is_rented' => $ukuranData->stok <= 0,
                ];
            } else {
                $stok[$uk] = [
                    'stok'      => 0,
                    'is_rented' => true,
                ];
            }
        }

        /**
         * =======================
         * PRODUK REKOMENDASI
         * =======================
         */
        $rekomendasi = Produk::withAvg('testimonis', 'rating')
            ->withCount('testimonis')
            ->where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $produk->id_produk)
            ->take(4)
            ->get();

        /**
         * =======================
         * WISHLIST STATUS
         * =======================
         */
        $isWishlisted = false;

        if (Auth::check()) {
            $isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('produk_id', $produk->id_produk)
                ->exists();
        }

        return view('user.detailProduk', compact(
            'produk',
            'stok',
            'rekomendasi',
            'isWishlisted'
        ));
    }
}
