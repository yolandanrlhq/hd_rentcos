<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlists = Wishlist::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.wishlist', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthenticated'
            ], 401);
        }

        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk'
        ]);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $request->id_produk)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'status' => 'removed'
            ]);
        }

        Wishlist::create([
            'user_id'   => Auth::id(),
            'produk_id' => $request->id_produk
        ]);

        return response()->json([
            'status' => 'added'
        ]);
    }
}
