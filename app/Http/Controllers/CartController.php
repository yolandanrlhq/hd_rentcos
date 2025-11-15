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

        // Ambil atau buat cart pending user
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        // Cek apakah item sudah ada di cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('id_produk', $produk->id_produk)
                            ->where('ukuran', $request->ukuran)
                            ->first();

        if ($cartItem) {
            // Update jumlah
            $cartItem->jumlah += $request->jumlah;
            $cartItem->save();
        } else {
            // Buat baru
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
        $item->jumlah = $request->jumlah;
        $item->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        return view('user.checkout', compact('cart'));
    }
}
