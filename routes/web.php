<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\CartController;
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
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/admin/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('admin.editProduk');
    Route::put('/admin/produk/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/admin/produk/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');
});


// ----------------------------
// USER (tanpa middleware)
// ----------------------------
Route::prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('user.editProfile');
    Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/produk', [UserProdukController::class, 'index'])->name('user.produk');
    Route::get('/produk/{id}', [UserProdukController::class, 'show'])->name('user.produk.show');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});


Route::get('/jadwalEvent', function () {
    return view('user.jadwalEvent');
})->name('user.jadwalEvent');
Route::get('/wishlist', function () {
    return view('user.wishlist');
})->name('user.wishlist');

