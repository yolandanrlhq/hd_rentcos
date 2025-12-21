<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * FORM LOGIN
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * PROSES LOGIN
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ JANGAN logout, arahkan ke verifikasi
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    /**
     * FORM REGISTER
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * PROSES REGISTER
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        // 🔥 KIRIM EMAIL VERIFIKASI
        $user->sendEmailVerificationNotification();

        // login dulu biar bisa buka halaman verify
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $role = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect sesuai role
        if ($role === 'admin') {
            return redirect('/login')->with('success', 'Admin berhasil logout');
        }

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
