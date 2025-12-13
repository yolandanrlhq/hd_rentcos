<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class UserProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('user.produk', compact('produks'));
    }

    public function show($id)
    {
        $produk = Produk::with('ukuran')->findOrFail($id);

        $ukuranCollection = $produk->ukuran;

        $ukuranList = ['S', 'M', 'L', 'XL','All Size'];
        $stok = [];

        foreach ($ukuranList as $uk) {
            $ukuranData = $ukuranCollection->firstWhere('nama_ukuran', $uk);

            if ($ukuranData) {
                // Ambil stok langsung dari tabel ukuran_produk
                $stok[$uk] = [
                    'stok' => $ukuranData->stok,
                    'is_rented' => $ukuranData->stok <= 0
                ];
            } else {
                $stok[$uk] = [
                    'stok' => 0,
                    'is_rented' => true
                ];
            }
        }

        $rekomendasi = Produk::where('id_kategori', $produk->id_kategori)
                            ->where('id_produk', '!=', $produk->id_produk)
                            ->take(4)
                            ->get();

        return view('user.detailProduk', compact('produk', 'stok', 'rekomendasi'));
    }
}
