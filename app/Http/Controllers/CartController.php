<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\Sewa;
use App\Models\SewaItem;
use App\Models\Notification;




class CartController extends Controller
{
    // Tampilkan keranjang user
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        $cartItems = $cart ? $cart->items()->with('produk')->get() : collect();
        $total = $cartItems->sum(fn($item) => $item->harga_satuan * $item->jumlah);

        return view('user.cart', compact('cart', 'cartItems', 'total'));
    }

    // Riwayat penyewaan dengan pagination
    public function status($status = null)
    {
        $userId = Auth::id();

        $query = Sewa::with('items.produk')
            ->where('user_id', $userId)
            ->where('status', '!=', 'pending');

        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        $sewas = $query->orderBy('updated_at', 'DESC')->paginate(10);

        return view('user.status', [
            'sewas' => $sewas,
            'filter' => $status ?? 'semua'
        ]);
    }

    // Tandai pesanan selesai
    public function complete($id)
    {
        $sewa = Sewa::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        if($sewa->status !== 'dikirim'){
            return back()->with('error', 'Pesanan belum dikirim, tidak bisa ditandai selesai.');
        }

        $sewa->status = 'selesai';
        $sewa->save();

        return back()->with('success', 'Pesanan telah selesai.');
    }

    // Batalkan pesanan
    public function cancel($id)
    {
        $sewa = Sewa::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        if(in_array($sewa->status, ['pending','menunggu_konfirmasi','diproses'])){
            $sewa->status = 'dibatalkan';
            $sewa->save();
            return back()->with('success', 'Pesanan telah dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    // Detail pesanan
    public function detail($id)
    {
        $sewa = Sewa::with('items.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.detail', compact('sewa'));
    }

    // Tambah produk ke cart
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

        $stokTersedia = $request->ukuran
            ? (\DB::table('ukuran_produk')->where('id_produk', $produk->id_produk)->where('nama_ukuran', $request->ukuran)->value('stok') ?? 0)
            : $produk->stok_produk;

        if ($request->jumlah > $stokTersedia) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'pending']);

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('id_produk', $produk->id_produk)
                            ->where('ukuran', $request->ukuran)
                            ->first();

        if($cartItem){
            $newJumlah = $cartItem->jumlah + $request->jumlah;
            if($newJumlah > $stokTersedia){
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
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

    // Update jumlah item cart
    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $produk = Produk::findOrFail($item->id_produk);

        $stokTersedia = $item->ukuran
            ? (\DB::table('ukuran_produk')->where('id_produk', $produk->id_produk)->where('nama_ukuran', $item->ukuran)->value('stok') ?? 0)
            : $produk->stok_produk;

        if($request->jumlah > $stokTersedia){
            return response()->json(['success' => false, 'message' => 'Jumlah melebihi stok tersedia.'], 400);
        }

        $item->jumlah = $request->jumlah;
        $item->save();

        return response()->json(['success' => true]);
    }

    // Hapus item dari cart
    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    // Checkout page
    public function checkout(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::where('user_id', Auth::id())->where('status','pending')->first();
        if(!$cart) return redirect()->route('cart.index')->with('error','Keranjang tidak ditemukan.');

        $selectedArray = is_array($request->query('selected', [])) ? $request->query('selected', []) : explode(',', $request->query('selected', ''));

        $items = CartItem::with('produk')->where('cart_id', $cart->id)->whereIn('id', $selectedArray)->get();
        if($items->isEmpty()) return redirect()->route('cart.index')->with('error','Item yang dipilih tidak ditemukan.');

        $subtotal = $items->sum(fn($i) => $i->harga_satuan * $i->jumlah);

        return view('user.checkout', compact('cart','items','subtotal','selectedArray'));
    }

    // Proses sewa
    public function sewa(Request $request)
    {
        $request->validate([
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'nullable|date|after:tanggal_sewa',
            'delivery_method' => 'required|string',
            'selected' => 'required|array|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->firstOrFail();

        $items = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $request->selected)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan.');
        }

        DB::transaction(function () use ($request, $cart, $items, &$sewa) {

            $totalHarga = $items->sum(fn($i) => $i->harga_satuan * $i->jumlah);

            // Buat data sewa (final transaksi)
            $sewa = Sewa::create([
                'user_id'         => Auth::id(),
                'cart_id'         => $cart->id,
                'status'          => 'menunggu_konfirmasi',
                'tanggal_sewa'    => $request->tanggal_sewa,
                'tanggal_kembali' => $request->tanggal_kembali,
                'delivery_method' => $request->delivery_method,
                'total_harga'     => $totalHarga
            ]);
            
            // ===============================
// 🔔 NOTIFIKASI USER
// ===============================
$namaProduk = $items->pluck('produk.nama_produk')->implode(', ');

Notification::create([
    'user_id' => Auth::id(),
    'judul'   => 'Pemesanan Berhasil',
    'pesan'   => 'Anda berhasil memesan kostum: ' . $namaProduk . 
                 '. Status pesanan: ' . $sewa->status,
    'ikon'    => 'shopping-bag-3-fill',
    'is_read' => false,
]);


            // Pindahkan item + potong stok
            foreach ($items as $i) {

                SewaItem::create([
                    'sewa_id'       => $sewa->id,
                    'produk_id'     => $i->id_produk,
                    'ukuran'        => $i->ukuran,
                    'jumlah'        => $i->jumlah,
                    'harga_satuan'  => $i->harga_satuan,
                    'subtotal'      => $i->harga_satuan * $i->jumlah
                ]);

                // Kurangi stok sesuai jumlah
                if ($i->ukuran) {
                    DB::table('ukuran_produk')
                        ->where('id_produk', $i->id_produk)
                        ->where('nama_ukuran', $i->ukuran)
                        ->decrement('stok', $i->jumlah);
                } else {
                    $i->produk->decrement('stok_produk', $i->jumlah);
                }
            }

            // Hapus item yang dicheckout
            CartItem::whereIn('id', $request->selected)->delete();

            // Update status cart
            $cart->update([
                'status' => 'menunggu_konfirmasi'
            ]);
        });

        return redirect()->route('checkout.success', $sewa);
    }
}
