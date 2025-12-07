<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\EventAdminController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

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
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Produk
    Route::get('/produk', [AdminProdukController::class, 'produk'])->name('admin.produk');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('admin.editProduk');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');
    Route::get('/event', [EventAdminController::class, 'index'])->name('admin.event.index');
    Route::get('/event/create', [EventAdminController::class, 'create'])->name('admin.event.create');
    Route::post('/event', [EventAdminController::class, 'store'])->name('admin.event.store');
    Route::get('/event/{id}/edit', [EventAdminController::class, 'edit'])->name('admin.event.edit');
    Route::put('/event/{id}', [EventAdminController::class, 'update'])->name('admin.event.update');
    Route::delete('/event/{id}', [EventAdminController::class, 'destroy'])->name('admin.event.destroy');
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
    Route::get('/pesan', [AdminController::class, 'pesan'])->name('admin.pesan');
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
    Route::get('/jadwal-event', [EventUserController::class, 'index'])->name('user.jadwalEvent');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post');
    Route::post('/sewa', [CartController::class, 'sewa'])->name('cart.sewa');
    Route::get('/cart/status/{status?}', [CartController::class, 'status'])->name('cart.status');
    Route::get('/cart/detail/{id}', [CartController::class, 'detail'])->name('cart.detail');
    Route::post('/cart/complete/{id}', [CartController::class, 'complete'])->name('cart.complete');
});
Route::get('/wishlist', function () {
    return view('user.wishlist');
})->name('user.wishlist');


// ===================== LED CONTROL =====================
Route::get('/control-led/{command}', function ($command) {
    $validCommands = ['naruto', 'sasuke', 'sakura', 'off'];

    if (!in_array(strtolower($command), $validCommands)) {
        return response()->json(['response' => 'Invalid command!']);
    }

    $esp32_ip = 'http://10.230.141.139/control?command=' . $command;
    $context = stream_context_create([
        'http' => ['timeout' => 1] // biar tidak nunggu lama
    ]);

    $response = @file_get_contents($esp32_ip, false, $context);

    if (!$response) {
        return response()->json(['response' => 'ESP32 tidak merespon']);
    }

    preg_match('/<p><b>Status LED:<\/b>\s*(.*?)<\/p>/', $response, $matches);
    $status = $matches[1] ?? 'Status tidak diketahui';

    return response()->json(['response' => $status]);
});


// ===================== RFID SCAN (VERSI CEPAT, TANPA LAG) =====================
Route::get('/rfid-scan', function () {

    // Ambil data dari cache dulu
    $cached = Cache::get('rfid_data');
    if ($cached) {
        return response()->json($cached);
    }

    $esp32_ip = 'http://10.230.141.139/rfid-scan';

    $context = stream_context_create([
        'http' => ['timeout' => 0.5] // timeout 0.5 detik biar web tidak ngelag
    ]);

    $response = @file_get_contents($esp32_ip, false, $context);

    if ($response === false) {
        // Jika ESP32 tidak merespon → tetap balikin data ringan
        return response()->json([
            'tag' => null,
            'kostum' => null
        ]);
    }

    // Simpan ke cache selama 3 detik
    $json = json_decode($response, true);
    Cache::put('rfid_data', $json, 3);

    return response()->json($json);
});


// ===================== HALAMAN ADMIN IoT =====================
Route::get('/admin/iot-control', function () {
    return view('admin.iotControl');
})->name('admin.iotControl');
