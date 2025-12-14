<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Notification;


class AdminProdukController extends Controller
{
    public function produk()
    {
        $produk = Produk::with(['kategori', 'ukuran'])->paginate(10);
        return view('admin.produk', compact('produk'));
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $produk = Produk::with('ukuran', 'fotos')->findOrFail($id);
        return view('admin.editProduk', compact('produk', 'kategori'));
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
            'fotos.*' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'ukuran.*.nama_ukuran' => 'nullable|string|max:10',
            'ukuran.*.stok' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan produk utama tanpa foto dulu
            $produk = Produk::create([
                'nama_produk' => $validated['nama_produk'],
                'id_kategori' => $validated['id_kategori'],
                'harga_produk' => $validated['harga_produk'],
                'stok_produk' => $validated['stok_produk'],
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

            // Simpan multiple fotos jika ada
            if ($request->hasFile('fotos')) {
                $firstFotoPath = null;
                foreach ($request->file('fotos') as $index => $fotoFile) {
                    $path = $fotoFile->store('produk', 'public');
                    \App\Models\ProdukFoto::create([
                        'id_produk' => $produk->id_produk,
                        'foto_path' => $path,
                    ]);
                    if ($index === 0) {
                        $firstFotoPath = $path;
                    }
                }
                // Update produk foto thumbnail with first foto
                if ($firstFotoPath) {
                    $produk->foto = $firstFotoPath;
                    $produk->save();
                }
            }

            DB::commit();

// ================= NOTIFIKASI KE SEMUA USER =================
$users = User::where('role', 'user')->get();

foreach ($users as $user) {
    Notification::create([
        'user_id' => $user->id,
        'judul'   => 'Kostum Baru Tersedia',
        'pesan'   => "Kostum {$produk->nama_produk} baru saja ditambahkan.",
        'ikon'    => 'shopping-bag',
        'is_read' => false,
    ]);
}
// ===========================================================

return redirect()
    ->route('admin.produk')
    ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'fotos.*' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'ukuran.*.nama_ukuran' => 'nullable|string|max:10',
            'ukuran.*.stok' => 'nullable|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);

        DB::beginTransaction();
        try {
            $produk->update([
                'nama_produk' => $validated['nama_produk'],
                'id_kategori' => $validated['id_kategori'],
                'harga_produk' => $validated['harga_produk'],
                'stok_produk' => $validated['stok_produk'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // UPDATE / INSERT ukuran per produk
            if ($request->has('ukuran')) {
                foreach ($request->ukuran as $ukuran) {
                    if (!empty($ukuran['nama_ukuran'])) {
                        UkuranProduk::updateOrCreate(
                            [
                                'id_produk' => $produk->id_produk,
                                'nama_ukuran' => $ukuran['nama_ukuran'],
                            ],
                            [
                                'stok' => $ukuran['stok'] ?? 0,
                            ]
                        );
                    }
                }

                $produk->updateStokTotal();
            }

            // Jika ada foto baru, hapus foto lama dulu lalu simpan foto baru
            if ($request->hasFile('fotos')) {
                // Hapus foto lama dari storage dan database
                $oldFotos = $produk->fotos;
                foreach ($oldFotos as $oldFoto) {
                    if (\Storage::disk('public')->exists($oldFoto->foto_path)) {
                        \Storage::disk('public')->delete($oldFoto->foto_path);
                    }
                    $oldFoto->delete();
                }

                // Simpan semua foto baru
                $paths = [];
                foreach ($request->file('fotos') as $fotoFile) {
                    $path = $fotoFile->store('produk', 'public');
                    \App\Models\ProdukFoto::create([
                        'id_produk' => $produk->id_produk,
                        'foto_path' => $path,
                    ]);
                    $paths[] = $path;
                }

                // Update produk foto thumbnail dengan foto pertama dari foto baru
                if (count($paths) > 0) {
                    $produk->foto = $paths[0];
                    $produk->save();
                }
            }

            DB::commit();
            return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }


}
