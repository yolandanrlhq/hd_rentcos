<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProdukController extends Controller
{
    public function produk()
    {
        $produk = Produk::with(['kategori', 'ukuran'])->get();
        return view('admin.produk', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'foto' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'ukuran.*.nama_ukuran' => 'nullable|string|max:10',
            'ukuran.*.stok' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan foto jika ada
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('produk', 'public');
            }

            // Simpan produk utama
            $produk = Produk::create([
                'nama_produk' => $validated['nama_produk'],
                'id_kategori' => $validated['id_kategori'],
                'harga_produk' => $validated['harga_produk'],
                'stok_produk' => $validated['stok_produk'],
                'foto' => $validated['foto'] ?? null,
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // Simpan ukuran jika ada
            if ($request->has('ukuran')) {
                foreach ($request->ukuran as $ukuran) {
                    if (!empty($ukuran['nama_ukuran'])) {
                        UkuranProduk::create([
                            'id_produk' => $produk->id_produk,
                            'nama_ukuran' => $ukuran['nama_ukuran'],
                            'stok' => $ukuran['stok'] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }
}
