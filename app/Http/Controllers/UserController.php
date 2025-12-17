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
     * DASHBOARD - BOLEH TANPA LOGIN
     */
    public function index()
    {
        $user = Auth::user(); // boleh null
        return view('user.dashboard', compact('user'));
    }

    /**
     * CEK LOGIN MANUAL (PUSAT)
     */
    private function requireLogin()
    {
        if (!Auth::check()) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return null;
    }

    /**
     * CHAT - WAJIB LOGIN
     */
    public function chat()
    {
        if ($redirect = $this->requireLogin()) return $redirect;

        $user = Auth::user();
        return view('user.pesan', compact('user'));
    }

    /**
     * PROFILE - WAJIB LOGIN
     */
    public function profile()
    {
        if ($redirect = $this->requireLogin()) return $redirect;

        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    /**
     * EDIT PROFILE - WAJIB LOGIN
     */
    public function editProfile()
    {
        if ($redirect = $this->requireLogin()) return $redirect;

        $user = Auth::user();
        return view('user.editProfil', compact('user'));
    }

    /**
     * UPDATE PROFILE - WAJIB LOGIN
     */
    public function updateProfile(Request $request)
    {
        if ($redirect = $this->requireLogin()) return $redirect;

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }

            $user->foto = $request->file('foto')->store('profile_photos', 'public');
        }

        $user->save();

        Notification::create([
            'user_id' => $user->id,
            'judul' => 'Profil Diperbarui',
            'pesan' => 'Profil Anda berhasil diperbarui.',
            'ikon' => 'user',
            'is_read' => false,
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
