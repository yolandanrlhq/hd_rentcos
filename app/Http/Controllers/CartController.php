<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\Sewa;
use App\Models\SewaItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        $cartItems = $cart ? $cart->items()->with('produk')->get() : collect();

        $total = $cartItems->sum(fn($item) => $item->harga_satuan * $item->jumlah);

        return view('user.cart', compact('cartItems', 'total'));
    }

    public function status($status = null)
    {
        $userId = Auth::id();

        $query = Sewa::with('items.produk')
            ->where('user_id', $userId)
            ->where('status', '!=', 'pending');

        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        $sewas = $query->orderBy('updated_at', 'DESC')->get();

        return view('user.status', [
            'sewas' => $sewas,
            'filter' => $status ?? 'semua'
        ]);
    }

    public function complete($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->status = 'Selesai';
        $cart->save();

        return redirect()->back()->with('success', 'Penyewaan selesai — terima kasih!');
    }

    public function detail($id)
    {
        $cart = Cart::with('produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'ukuran' => 'nullable|string',
            'jumlah' => 'required|integer|min:1'
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $produk = Produk::findOrFail($request->id_produk);

        // ----------------------------
        // CEK STOK BERDASARKAN UKURAN
        // ----------------------------
        if ($request->ukuran) {
            // cari stok dari tabel UKURAN
            $ukuran = \DB::table('ukuran_produk')
                ->where('id_produk', $produk->id_produk)
                ->where('nama_ukuran', $request->ukuran)
                ->first();

            if (!$ukuran) {
                return redirect()->back()->with('error', 'Ukuran tidak ditemukan.');
            }

            $stokTersedia = $ukuran->stok;
        } else {
            // tanpa ukuran → pakai stok_produk
            $stokTersedia = $produk->stok_produk;
        }

        // CEK JUMLAH MELEBIHI STOK
        if ($request->jumlah > $stokTersedia) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        // Ambil / buat cart pending
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        // Cek item sudah ada atau belum
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('id_produk', $produk->id_produk)
                            ->where('ukuran', $request->ukuran)
                            ->first();

        if ($cartItem) {

            $newJumlah = $cartItem->jumlah + $request->jumlah;

            // CEK LAGI (UPDATE JUMLAH)
            if ($newJumlah > $stokTersedia) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia.');
            }

            $cartItem->jumlah = $newJumlah;
            $cartItem->save();

        } else {

            CartItem::create([
                'cart_id' => $cart->id,
                'id_produk' => $produk->id_produk,
                'ukuran' => $request->ukuran,
                'harga_satuan' => $produk->harga_produk,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $produk = Produk::findOrFail($item->id_produk);

        // CEK STOK BY UKURAN
        if ($item->ukuran) {
            $ukuran = \DB::table('ukuran_produk')
                ->where('id_produk', $produk->id_produk)
                ->where('nama_ukuran', $item->ukuran)
                ->first();

            $stokTersedia = $ukuran->stok;
        } else {
            $stokTersedia = $produk->stok_produk;
        }

        if ($request->jumlah > $stokTersedia) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia.'
            ], 400);
        }

        $item->jumlah = $request->jumlah;
        $item->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang tidak ditemukan.');
        }

        $selected = $request->query('selected', []);

        if (empty($selected)) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu produk sebelum checkout.');
        }

        $selectedArray = is_array($selected) ? $selected : explode(',', $selected);

        $items = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $selectedArray)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan.');
        }

        $total = $items->sum(fn($i) => $i->harga_satuan * $i->jumlah);

        return view('user.checkout', compact('cart', 'items', 'total', 'selectedArray'));
    }


    public function sewa(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|string',
            'selected' => 'required|array'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $items = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $request->selected)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan.');
        }

        // hitung total harga
        $totalHarga = $items->sum(fn($i) => $i->harga_satuan * $i->jumlah);

        // 1️⃣ Buat data di tabel sewa
        $sewa = Sewa::create([
            'user_id' => Auth::id(),
            'status' => 'menunggu_konfirmasi',
            'tanggal_sewa' => now(),
            'tanggal_kembali' => null,
            'total_harga' => $totalHarga
        ]);

        // 2️⃣ Insert ke tabel sewa_items + kurangi stok produk
        foreach ($items as $i) {

            // buat sewa item
            SewaItem::create([
                'sewa_id' => $sewa->id,
                'produk_id' => $i->id_produk,
                'ukuran' => $i->ukuran,
                'jumlah' => $i->jumlah,
                'harga_satuan' => $i->harga_satuan,
                'subtotal' => $i->harga_satuan * $i->jumlah
            ]);

            // KURANGI STOK BERDASARKAN UKURAN
            if ($i->ukuran) {
                // decrement stok di ukuran_produk
                \DB::table('ukuran_produk')
                    ->where('id_produk', $i->id_produk)
                    ->where('nama_ukuran', $i->ukuran)
                    ->decrement('stok', $i->jumlah);

                // reload produk dari DB untuk update stok total
                $produk = Produk::find($i->id_produk);
                $produk->updateStokTotal(); // update stok_produk = sum(stok ukuran)
            } else {
                // tanpa ukuran → decrement stok_produk langsung
                $i->produk->decrement('stok_produk', $i->jumlah);
            }
        }

        // 3️⃣ Hapus item dari cart (yang di-checkout saja)
        CartItem::whereIn('id', $request->selected)->delete();

        // 4️⃣ Update cart status (bukan pending lagi)
        $cart->status = 'menunggu_konfirmasi';
        $cart->delivery_method = $request->delivery_method;
        $cart->save();

        return redirect()->route('cart.status')
            ->with('success', 'Checkout berhasil! Silakan tunggu konfirmasi admin.');
    }
}
