<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Halaman dashboard admin
     */
    public function index()
    {
        // Cek user login dan role
        $user = Auth::user(); // VSCode/Intelephense akan mengenali User
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.dashboard', compact('user'));
    }

    /**
     * Contoh halaman manajemen user (opsional)
     */
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
}
