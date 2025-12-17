<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Sewa;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    // Tampilkan semua pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with('sewa.user')->latest()->paginate(10);
        return view('admin.pengembalian', compact('pengembalians'));
    }

    // Tampilkan form edit / update pengembalian
    public function edit($id)
    {
        $pengembalian = Pengembalian::with('sewa.user')->findOrFail($id);
        return view('admin.editPengembalian', compact('pengembalian'));
    }

    // Update pengembalian
    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'status' => 'required|in:belum_dikembalikan,diproses,selesai',
            'denda' => 'nullable|integer|min:0',
            'catatan_admin' => 'nullable|string|max:500',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update file jika ada
        if ($request->hasFile('bukti_foto')) {
            if ($pengembalian->bukti_foto && Storage::disk('public')->exists($pengembalian->bukti_foto)) {
                Storage::disk('public')->delete($pengembalian->bukti_foto);
            }

            $file = $request->file('bukti_foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('pengembalian', $filename, 'public');
            $pengembalian->bukti_foto = $path;
        }

        $pengembalian->status = $request->status;
        $pengembalian->denda = $request->denda;
        $pengembalian->catatan_admin = $request->catatan_admin;
        $pengembalian->save();

        // Notifikasi ke user
        Notification::create([
            'user_id' => $pengembalian->sewa->user_id,
            'judul' => 'Status Pengembalian',
            'pesan' => "Pengembalian pesanan #{$pengembalian->sewa_id} sekarang {$pengembalian->status}.",
            'ikon' => 'bell',
            'is_read' => false,
        ]);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }
}
