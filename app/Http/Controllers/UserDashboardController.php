<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Produk rekomendasi (misalnya random / kategori kostum)
        $rekomendasi = Produk::latest()->take(6)->get();

        // Produk terbaru
        $latest = Produk::orderBy('created_at', 'desc')->take(6)->get();

        return view('user.dashboard', compact('rekomendasi', 'latest'));
    }
}
