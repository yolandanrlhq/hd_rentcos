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

        // ambil stok dari database (misal hasilnya ['M' => 3, 'L' => 2])
        $stokDB = $produk->ukuran->pluck('stok', 'nama_ukuran')->toArray();

        // daftar semua ukuran yang ingin ditampilkan
        $ukuranList = ['S', 'M', 'L', 'XL'];

        // buat array stok lengkap (kalau ukuran gak ada di DB, stok = 0)
        $stok = [];
        foreach ($ukuranList as $uk) {
            $stok[$uk] = $stokDB[$uk] ?? 0;
        }

        $rekomendasi = Produk::where('id_kategori', $produk->id_kategori)
                            ->where('id_produk', '!=', $produk->id_produk)
                            ->take(4)
                            ->get();

        return view('user.detailProduk', compact('produk', 'stok', 'rekomendasi'));
    }
}
