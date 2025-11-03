<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Contoh halaman profil user
     */
    public function profile()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            abort(403, 'Akses ditolak.');
        }

        return view('user.profile', compact('user'));
    }
}
