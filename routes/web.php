<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ----------------------------
// AUTH
// ----------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ----------------------------
// ADMIN (tanpa middleware)
// ----------------------------
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// ----------------------------
// USER (tanpa middleware)
// ----------------------------
Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
