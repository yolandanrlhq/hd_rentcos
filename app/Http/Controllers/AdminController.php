<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Sewa;


class AdminController extends Controller
{
    public function index()
    {
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
        $gagal = \App\Models\Sewa::where('status', 'dibatalkan')->count();
        $pending = \App\Models\Sewa::where('status', 'pending')->count();
        $diproses = \App\Models\Sewa::where('status', 'diproses')->count();
        $dikirim = \App\Models\Sewa::where('status', 'dikirim')->count();

        return view('admin.pesanan', compact('user', 'pesanan', 'total', 'berhasil', 'gagal', 'pending', 'diproses', 'dikirim'));
    }

    public function updateStatusPesanan(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan',
    ]);

    // Ambil pesanan + relasi
    $pesanan = Sewa::with('items.produk')->findOrFail($id);

    // Simpan status lama
    $statusLama = $pesanan->status;

    // Update status baru
    $pesanan->status = $request->status;
    $pesanan->save();

    // Ambil nama kostum (bisa lebih dari satu)
    $namaProduk = $pesanan->items
        ->pluck('produk.nama_produk')
        ->join(', ');

    // ================= NOTIFIKASI USER =================
    Notification::create([
    'user_id' => $pesanan->user_id,
    'judul'   => 'Status Pesanan',
    'pesan'   => "Penyewaan {$namaProduk} sekarang {$pesanan->status}.",
    'ikon'    => 'bell',
    'is_read' => false,
]);

    // ===================================================

    return response()->json([
        'success' => true,
        'message' => 'Status pesanan berhasil diperbarui'
    ]);
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
