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
use App\Models\Pengembalian;
use App\Models\Message;

class CartController extends Controller
{
    // =====================
    // Pastikan user login
    // =====================
    private function mustLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return null;
    }

    // =====================
    // Tampilkan keranjang
    // =====================
    public function index()
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        $cartItems = $cart ? $cart->items()->with('produk')->get() : collect();
        $total = $cartItems->sum(fn ($item) => $item->harga_satuan * $item->jumlah);

        return view('user.cart', compact('cart', 'cartItems', 'total'));
    }

    // =====================
    // Riwayat penyewaan + filter
    // =====================
    public function status($status = null)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $query = Sewa::with(['items.produk', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'pending');

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        $sewas = $query->orderBy('updated_at', 'DESC')->paginate(10);

        return view('user.status', [
            'sewas'  => $sewas,
            'filter' => $status ?? 'semua'
        ]);
    }

    // =====================
    // Tandai selesai
    // =====================
    public function complete($id)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $sewa = Sewa::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($sewa->status !== 'dikirim') {
            return back()->with('error', 'Pesanan belum dikirim.');
        }

        DB::transaction(function () use ($sewa) {
            $sewa->update(['status' => 'selesai']);

            // Otomatis buat record pengembalian jika belum ada
            if (!$sewa->pengembalian) {
                Pengembalian::create([
                    'sewa_id' => $sewa->id,
                    'status'  => 'belum_dikembalikan',
                ]);
            }
        });

        return back()->with('success', 'Pesanan selesai.');
    }

    // =====================
    // Batalkan pesanan
    // =====================
    public function cancel($id)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $sewa = Sewa::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (in_array($sewa->status, ['pending', 'menunggu_konfirmasi', 'diproses'])) {
            $sewa->update(['status' => 'dibatalkan']);
            return back()->with('success', 'Pesanan dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    // =====================
    // Detail pesanan
    // =====================
    public function detail($id)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $sewa = Sewa::with(['items.produk', 'pengembalian'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.detail', compact('sewa'));
    }

    // =====================
    // Tambah ke cart
    // =====================
    public function store(Request $request)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'ukuran'    => 'nullable|string',
            'jumlah'    => 'required|integer|min:1'
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        $stokTersedia = $request->ukuran
            ? (DB::table('ukuran_produk')
                ->where('id_produk', $produk->id_produk)
                ->where('nama_ukuran', $request->ukuran)
                ->value('stok') ?? 0)
            : $produk->stok_produk;

        if ($request->jumlah > $stokTersedia) {
            return back()->with('error', 'Jumlah melebihi stok.');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status'  => 'pending'
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('id_produk', $produk->id_produk)
            ->where('ukuran', $request->ukuran)
            ->first();

        if ($item) {
            $newJumlah = $item->jumlah + $request->jumlah;
            if ($newJumlah > $stokTersedia) {
                return back()->with('error', 'Jumlah melebihi stok.');
            }
            $item->update(['jumlah' => $newJumlah]);
        } else {
            CartItem::create([
                'cart_id'       => $cart->id,
                'id_produk'     => $produk->id_produk,
                'ukuran'        => $request->ukuran,
                'harga_satuan'  => $produk->harga_produk,
                'jumlah'        => $request->jumlah,
            ]);
        }

                        // ambil item cart yang barusan diproses
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('id_produk', $produk->id_produk)
                    ->where('ukuran', $request->ukuran)
                    ->first();

                // JIKA CHECKOUT SEKARANG
                if ($request->action === 'checkout') {
                    return redirect()->route('cart.checkout', [
                        'selected' => [$cartItem->id]
                    ]);
                }

                // DEFAULT: TAMBAH KERANJANG
                return redirect()->route('cart.index')
                    ->with('success', 'Produk ditambahkan ke keranjang.');

    }

    // =====================
    // Update jumlah item
    // =====================
    public function update(Request $request, $id)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $item = CartItem::findOrFail($id);
        $produk = Produk::findOrFail($item->id_produk);

        $stokTersedia = $item->ukuran
            ? (DB::table('ukuran_produk')
                ->where('id_produk', $produk->id_produk)
                ->where('nama_ukuran', $item->ukuran)
                ->value('stok') ?? 0)
            : $produk->stok_produk;

        if ($request->jumlah > $stokTersedia) {
            return response()->json(['success' => false], 400);
        }

        $item->update(['jumlah' => $request->jumlah]);

        return response()->json(['success' => true]);
    }

    // =====================
    // Hapus item
    // =====================
    public function destroy($id)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        CartItem::findOrFail($id)->delete();

        return back()->with('success', 'Item dihapus.');
    }

    // =====================
    // Checkout
    // =====================
    public function checkout(Request $request)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $selected = is_array($request->query('selected'))
            ? $request->query('selected')
            : explode(',', $request->query('selected', ''));

        $items = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $selected)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
        }

        $subtotal = $items->sum(fn ($i) => $i->harga_satuan * $i->jumlah);

        return view('user.checkout', compact('cart', 'items', 'subtotal', 'selected'));
    }

    // =====================
    // Proses sewa
    // =====================
    public function sewa(Request $request)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $request->validate([
            'tanggal_sewa'    => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'nullable|date|after:tanggal_sewa',
            'delivery_method' => 'required|string',
            'selected'        => 'required|array|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $items = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $request->selected)
            ->get();

        DB::transaction(function () use ($request, $cart, $items, &$sewa) {
            $total = $items->sum(fn ($i) => $i->harga_satuan * $i->jumlah);

            $sewa = Sewa::create([
                'user_id'         => Auth::id(),
                'cart_id'         => $cart->id,
                'status'          => 'menunggu_konfirmasi',
                'tanggal_sewa'    => $request->tanggal_sewa,
                'tanggal_kembali' => $request->tanggal_kembali,
                'delivery_method' => $request->delivery_method,
                'total_harga'     => $total
            ]);


            Notification::create([
                'user_id' => Auth::id(),
                'judul'   => 'Pemesanan Berhasil',
                'pesan'   => 'Pesanan berhasil dibuat.',
                'ikon'    => 'shopping-bag-3-fill',
                'is_read' => false,
            ]);

            foreach ($items as $i) {
                SewaItem::create([
                    'sewa_id'      => $sewa->id,
                    'produk_id'    => $i->id_produk,
                    'ukuran'       => $i->ukuran,
                    'jumlah'       => $i->jumlah,
                    'harga_satuan' => $i->harga_satuan,
                    'subtotal'     => $i->harga_satuan * $i->jumlah
                ]);
                            // =====================
            // KIRIM PESAN OTOMATIS KE ADMIN (TAMBAHAN)
            // =====================
            $adminId = 1;
            $user = Auth::user();

            // Susun daftar item
            $itemList = '';
            foreach ($items as $i) {
                $itemList .= "- {$i->produk->nama_produk}";
                if ($i->ukuran) {
                    $itemList .= " ({$i->ukuran})";
                }
                $itemList .= " ({$i->jumlah}x)\n";
            }

            // Ambil alamat user (jika ada)
            $alamat = $user->address ?? '-';

            // Susun pesan
            $pesan  = "📦 DETAIL PESANAN\n";
            $pesan .= "--------------------------\n";
            $pesan .= "Nama      : {$user->name}\n";
            $pesan .= "Alamat    : {$alamat}\n";
            $pesan .= "Pengiriman: {$request->delivery_method}\n\n";
            $pesan .= "Daftar Item:\n{$itemList}\n";
            $pesan .= "--------------------------\n";
            $pesan .= "Total : Rp" . number_format($total, 0, ',', '.');

            // SIMPAN PESAN KE CHAT
            Message::create([
                'sender_id'   => $user->id,
                'receiver_id' => $adminId,
                'message'     => $pesan,
                'is_read'     => false,
            ]);


                // Kurangi stok
                if ($i->ukuran) {
                    DB::table('ukuran_produk')
                        ->where('id_produk', $i->id_produk)
                        ->where('nama_ukuran', $i->ukuran)
                        ->decrement('stok', $i->jumlah);
                } else {
                    $i->produk->decrement('stok_produk', $i->jumlah);
                }
            }

            // Hapus item cart dan ubah status cart
            CartItem::whereIn('id', $request->selected)->delete();

        });

        return redirect()->route('checkout.success', $sewa);
    }
}
