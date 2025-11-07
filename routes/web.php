<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminProdukController;
use Illuminate\Support\Facades\Route;

// ----------------------------
// AUTH
// ----------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// -------A---------------------
// ADMIN (tanpa middleware)
// ----------------------------
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Produk
    Route::get('/produk', [AdminProdukController::class, 'produk'])->name('admin.produk');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
});


// ----------------------------
// USER (tanpa middleware)
// ----------------------------
Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/produk', function () {
    return view('user.produk');
})->name('user.produk');
Route::get('/jadwalEvent', function () {
    return view('user.jadwalEvent');
})->name('user.jadwalEvent');
Route::get('/wishlist', function () {
    return view('user.wishlist');
})->name('user.wishlist');

