<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Sewa;
use App\Models\Pengembalian;
use App\Models\User;
use App\Models\Produk;

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

    public function index()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $totalPelanggan = User::where('role','user')->count();
        $pendapatan     = Sewa::where('status','selesai')->sum('total_harga');
        $totalProduk    = Produk::count();
        $totalPesanan   = Sewa::count();

        // Chart default per bulan (Bulan ini)
        $chartLabels = [];
        $chartValues = [];
        $currentMonth = now()->month;
        $currentYear  = now()->year;

        for($day = 1; $day <= 31; $day++){
            if(!checkdate($currentMonth,$day,$currentYear)) continue;
            $chartLabels[] = $day;
            $chartValues[] = Sewa::whereYear('tanggal_sewa',$currentYear)
                                ->whereMonth('tanggal_sewa',$currentMonth)
                                ->whereDay('tanggal_sewa',$day)
                                ->sum('total_harga');
        }

        return view('admin.dashboard', compact(
            'totalPelanggan','pendapatan','totalProduk','totalPesanan','chartLabels','chartValues'
        ));
    }

    public function dashboardData(Request $request)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $period = $request->get('period','month');
        $labels = [];
        $data   = [];

        switch($period){
            case 'day':
                $start = now()->subDays(6);
                $end   = now();
                for($d = $start; $d <= $end; $d->addDay()){
                    $labels[] = $d->format('D');
                    $data[] = Sewa::where('status','selesai')
                                ->whereDate('tanggal_sewa',$d)
                                ->sum('total_harga');
                }
                break;
            case 'month':
                $year = now()->year;
                for($m=1;$m<=12;$m++){
                    $labels[] = date('M', mktime(0,0,0,$m,1));
                    $data[]   = Sewa::where('status','selesai')
                                    ->whereMonth('tanggal_sewa',$m)
                                    ->whereYear('tanggal_sewa',$year)
                                    ->sum('total_harga');
                }
                break;
            case 'year':
                $startYear = now()->year - 4;
                for($y=$startYear;$y<=now()->year;$y++){
                    $labels[] = $y;
                    $data[]   = Sewa::where('status','selesai')
                                    ->whereYear('tanggal_sewa',$y)
                                    ->sum('total_harga');
                }
                break;
        }

        return response()->json([
            'labels'         => $labels,
            'data'           => $data,
            'totalPendapatan'=> Sewa::where('status','selesai')->sum('total_harga'),
            'totalPelanggan' => User::where('role','user')->count(),
            'totalProduk'    => Produk::count(),
            'totalPesanan'   => Sewa::count(),
        ]);
    }

    /**
     * KELOLA USER
     */
    public function manageUsers()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * HALAMAN USER ADMIN (Role user saja)
     */
    public function user()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $users = User::where('role','user')->get();
        return view('admin.user', compact('users'));
    }

    /**
     * PESANAN
     */
    public function pesanan()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $pesanan = Sewa::with(['user', 'items.produk', 'pengembalian'])
            ->orderBy('tanggal_sewa','desc')
            ->paginate(10);

        $total     = Sewa::count();
        $berhasil  = Sewa::where('status','selesai')->count();
        $gagal     = Sewa::where('status','dibatalkan')->count();
        $pending   = Sewa::where('status','pending')->count();
        $diproses  = Sewa::where('status','diproses')->count();
        $dikirim   = Sewa::where('status','dikirim')->count();

        return view('admin.pesanan', compact(
            'pesanan','total','berhasil','gagal','pending','diproses','dikirim'
        ));
    }

    /**
     * UPDATE STATUS PESANAN
     */
    public function updateStatusPesanan(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role!=='admin') {
            return response()->json(['success'=>false,'message'=>'Unauthorized'],401);
        }

        $request->validate([
            'status'=>'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan',
        ]);

        $pesanan = Sewa::with('items.produk')->findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        if($request->status==='selesai' && !$pesanan->pengembalian){
            Pengembalian::create([
                'sewa_id'=>$pesanan->id,
                'status'=>'belum_dikembalikan'
            ]);
        }

        $namaProduk = $pesanan->items->pluck('produk.nama_produk')->join(', ');

        Notification::create([
            'user_id'=>$pesanan->user_id,
            'judul'=>'Status Pesanan',
            'pesan'=>"Penyewaan {$namaProduk} sekarang {$pesanan->status}.",
            'ikon'=>'bell',
            'is_read'=>false
        ]);

        return response()->json(['success'=>true,'message'=>'Status pesanan berhasil diperbarui']);
    }

    /**
     * UPDATE STATUS PENGEMBALIAN
     */
    public function updateStatusPengembalian(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role!=='admin') {
            return response()->json(['success'=>false,'message'=>'Unauthorized'],401);
        }

        $request->validate([
            'status'=>'required|in:belum_dikembalikan,diproses,selesai',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = $request->status;
        $pengembalian->save();

        Notification::create([
            'user_id'=>$pengembalian->sewa->user_id,
            'judul'=>'Status Pengembalian',
            'pesan'=>"Pengembalian pesanan #{$pengembalian->sewa_id} sekarang {$pengembalian->status}.",
            'ikon'=>'bell',
            'is_read'=>false
        ]);

        return response()->json(['success'=>true,'message'=>'Status pengembalian berhasil diperbarui']);
    }

    /**
     * HALAMAN PESAN ADMIN
     */
    public function pesan()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        // Ambil semua user dengan role 'user'
        $users = User::where('role', 'user')->get();

        // Kirim ke view
        return view('admin.pesan', compact('users'));
    }
}
