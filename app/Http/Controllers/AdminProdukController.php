<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
    public function produk()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.produk', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|integer',
            'ukuran_produk' => 'nullable|string',
            'foto' => 'nullable|image',
            'id_kategori' => 'required|exists:kategori,id_kategori',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($validated);
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }
}
