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

        $ukuranList = ['S', 'M', 'L', 'XL','All Size'];

        $stok = [];
        foreach ($ukuranList as $uk) {
            $ukuranData = $ukuranCollection->firstWhere('nama_ukuran', $uk);

            if ($ukuranData) {
                $dipinjam = \DB::table('sewa_items')
                    ->join('sewa', 'sewa_items.sewa_id', '=', 'sewa.id')
                    ->where('sewa_items.produk_id', $produk->id_produk)
                    ->where('sewa_items.ukuran', $uk)
                    ->whereIn('sewa.status', ['menunggu_konfirmasi', 'disewa']) // termasuk pending / belum selesai
                    ->sum('sewa_items.jumlah');

                $sisa = max($ukuranData->stok - $dipinjam, 0);

                $stok[$uk] = [
                    'stok' => $sisa,
                    'is_rented' => $sisa <= 0
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
