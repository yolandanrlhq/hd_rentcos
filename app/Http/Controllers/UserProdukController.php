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

        // ambil stok dan is_rented dari database (misal hasilnya ['M' => ['stok'=>3,'is_rented'=>false], ...])
        $ukuranCollection = $produk->ukuran;

        $ukuranList = ['S', 'M', 'L', 'XL'];

        $stok = [];
        foreach ($ukuranList as $uk) {
            $ukuranData = $ukuranCollection->firstWhere('nama_ukuran', $uk);
            if ($ukuranData) {
                $stok[$uk] = [
                    'stok' => $ukuranData->stok,
                    'is_rented' => $ukuranData->is_rented
                ];
            } else {
                $stok[$uk] = [
                    'stok' => 0,
                    'is_rented' => false
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
