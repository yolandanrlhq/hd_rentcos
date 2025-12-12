<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Cek user login dan role
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.dashboard', compact('user'));
    }

    public function manageUsers()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // Ambil semua user
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    public function jadwalEvent()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.jadwalEvent', compact('user'));
    }

    public function pesanan()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $pesanan = \App\Models\Sewa::with(['user', 'items.produk'])->orderBy('tanggal_sewa', 'desc')->paginate(10);

        $total = \App\Models\Sewa::count();
        $berhasil = \App\Models\Sewa::where('status', 'selesai')->count();
        $gagal = \App\Models\Sewa::where('status', 'batal')->count();
        $pending = \App\Models\Sewa::where('status', 'pending')->count();

        return view('admin.pesanan', compact('user', 'pesanan', 'total', 'berhasil', 'gagal', 'pending'));
    }

    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        $pesanan = \App\Models\Sewa::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return response()->json(['success' => true]);
    }

    public function user()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.user', compact('user'));
    }

    public function pesan()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.pesan', compact('user'));
    }
}
