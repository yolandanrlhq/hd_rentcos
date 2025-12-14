<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;


class UserController extends Controller
{
    /**
     * Halaman dashboard user
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            abort(403, 'Akses ditolak.');
        }

        return view('user.dashboard', compact('user'));
    }

    public function chat()
    {
        $user = Auth::user();
        return view('user.pesan', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user(); // Ambil data user yang login
        return view('user.profil', compact('user'));
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update field dasar
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;

    // Update password jika ada
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Update foto jika ada
    if ($request->hasFile('foto')) {
        if ($user->foto && \Storage::exists('public/' . $user->foto)) {
            \Storage::delete('public/' . $user->foto);
        }

        $path = $request->file('foto')->store('profile_photos', 'public');
        $user->foto = $path;
    }

    // SIMPAN USER
    $user->save();

    // ================= NOTIFIKASI =================
    Notification::create([
        'user_id' => $user->id,
        'judul'   => 'Profil Diperbarui',
        'pesan'   => 'Profil Anda berhasil diperbarui.',
        'ikon'    => 'user',
        'is_read' => false,
    ]);
    // ==============================================

    return redirect()
        ->route('user.profile')
        ->with('success', 'Profil berhasil diperbarui!');
}


    public function editProfile()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('user.editProfil', compact('user'));
    }
}
