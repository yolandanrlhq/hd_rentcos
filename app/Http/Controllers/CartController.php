<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

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

    $query = Cart::with('produk')
        ->where('user_id', $userId)
        ->where('status', '!=', 'pending'); // agar yang belum checkout tidak ditampilkan

    if ($status && $status != 'semua') {
        $query->where('status', $status);
    }

    $carts = $query->orderBy('updated_at', 'DESC')->get();

    return view('user.status', [
        'carts' => $carts,
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
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $validDeliveryMethods = ['cod', 'ambil_ditempat', 'antar_ke_rumah', 'via_ekspedisi'];

        if ($request->isMethod('post')) {
            $request->validate([
                'delivery_method' => ['required', 'string', 'in:' . implode(',', $validDeliveryMethods)]
            ]);

            $cart->delivery_method = $request->input('delivery_method');
            $cart->status = 'menunggu_konfirmasi';
            $cart->save();

            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            foreach ($cartItems as $cartItem) {
                $cartItem->is_checked_out = true;
                $cartItem->save();
            }

            // After saving shipping method, mark the rented items
            $selected = $request->query('selected', []);
            $selectedArray = is_array($selected) ? $selected : explode(',', $selected);

            // Update ukuran_produk is_rented to true for each selected cart item ukuran
            $cartItems = \App\Models\CartItem::where('cart_id', $cart->id)
                ->whereIn('id', $selectedArray)
                ->get();

            foreach ($cartItems as $cartItem) {
                if ($cartItem->ukuran) {
                    \DB::table('ukuran_produk')
                        ->where('id_produk', $cartItem->id_produk)
                        ->where('nama_ukuran', $cartItem->ukuran)
                        ->update(['is_rented' => true]);
                }
            }

            return redirect()->route('cart.sewa', ['selected' => implode(',', $selectedArray)]);
        }

        // if selected ids are provided (from cart page), only include those items
        $selected = $request->query('selected', []);

        if (empty($selected)) {
            // no selected items — require user to pick at least one from cart
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu produk sebelum checkout.');
        }

        // load only items that belong to this cart and were selected
        $items = \App\Models\CartItem::where('cart_id', $cart->id)
                    ->whereIn('id', (array) $selected)
                    ->with('produk')
                    ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item terpilih tidak ditemukan di keranjang Anda.');
        }

        return view('user.checkout', compact('cart', 'items'));
    }

    public function sewa(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'menunggu_konfirmasi')
                    ->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $selected = $request->query('selected', []);

        if (empty($selected)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $selectedArray = is_array($selected) ? $selected : explode(',', $selected);

        $items = \App\Models\CartItem::where('cart_id', $cart->id)
                    ->whereIn('id', $selectedArray)
                    ->with('produk')
                    ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan.');
        }

        return view('user.sewa', compact('items'));
    }
}
