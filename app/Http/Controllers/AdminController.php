<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Sewa;
use App\Models\Pengembalian;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * CEK ADMIN MANUAL
     */
    private function requireAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')
                ->with('error', 'Akses admin. Silakan login sebagai admin.');
        }
        return null;
    }

    /**
     * DASHBOARD ADMIN
     */
    public function index()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    /**
     * KELOLA USER
     */
    public function manageUsers()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * PESANAN
     */
    public function pesanan()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $pesanan = Sewa::with(['user', 'items.produk', 'pengembalian'])
            ->orderBy('tanggal_sewa', 'desc')
            ->paginate(10);

        $total     = Sewa::count();
        $berhasil  = Sewa::where('status', 'selesai')->count();
        $gagal     = Sewa::where('status', 'dibatalkan')->count();
        $pending   = Sewa::where('status', 'pending')->count();
        $diproses  = Sewa::where('status', 'diproses')->count();
        $dikirim   = Sewa::where('status', 'dikirim')->count();

        return view('admin.pesanan', compact(
            'pesanan',
            'total',
            'berhasil',
            'gagal',
            'pending',
            'diproses',
            'dikirim'
        ));
    }

    /**
     * UPDATE STATUS PESANAN (AJAX SAFE)
     */
    public function updateStatusPesanan(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan',
        ]);

        $pesanan = Sewa::with('items.produk')->findOrFail($id);

        $pesanan->status = $request->status;
        $pesanan->save();

        // Jika status selesai, otomatis buat pengembalian jika belum ada
        if ($request->status === 'selesai' && !$pesanan->pengembalian) {
            Pengembalian::create([
                'sewa_id' => $pesanan->id,
                'status'  => 'belum_dikembalikan',
            ]);
        }

        $namaProduk = $pesanan->items
            ->pluck('produk.nama_produk')
            ->join(', ');

        Notification::create([
            'user_id' => $pesanan->user_id,
            'judul'   => 'Status Pesanan',
            'pesan'   => "Penyewaan {$namaProduk} sekarang {$pesanan->status}.",
            'ikon'    => 'bell',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui'
        ]);
    }

    /**
     * UPDATE STATUS PENGEMBALIAN
     */
    public function updateStatusPengembalian(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->validate([
            'status' => 'required|in:belum_dikembalikan,diproses,selesai',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = $request->status;
        $pengembalian->save();

        // Notifikasi ke user
        Notification::create([
            'user_id' => $pengembalian->sewa->user_id,
            'judul'   => 'Status Pengembalian',
            'pesan'   => "Pengembalian pesanan #{$pengembalian->sewa_id} sekarang {$pengembalian->status}.",
            'ikon'    => 'bell',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pengembalian berhasil diperbarui'
        ]);
    }

    /**
     * HALAMAN USER ADMIN
     */
    public function user()
{
    $admin = Auth::user();
    if (!$admin || $admin->role !== 'admin') {
        abort(403, 'Akses ditolak.');
    }

    // Ambil semua user (atau filter role user)
    $users = User::where('role', 'user')->get();

    return view('admin.user', compact('users'));
}

    /**
     * PESAN ADMIN
     */
    public function pesan()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        return view('admin.pesan');
    }
}
