<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\EventAdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\TestimoniController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| USER - PUBLIC (TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/user/dashboard');
});

Route::prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/produk', [UserProdukController::class, 'index'])->name('user.produk');
    Route::get('/produk/{id}', [UserProdukController::class, 'show'])->name('user.produk.show');
    Route::get('/jadwal-event', [EventUserController::class, 'index'])->name('user.jadwalEvent');
});

/*
|--------------------------------------------------------------------------
| USER - WAJIB LOGIN (CEK DI CONTROLLER / ROUTE)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {

    // PROFIL
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('user.editProfile');
    Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');

    // WISHLIST
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{produkId}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{produkId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // CHECKOUT & SEWA & PENGEMBALIAN
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/sewa', [CartController::class, 'sewa'])->name('cart.sewa');
    Route::get('/checkout/success/{sewa}', function ($sewa) {
        return view('user.checkoutSuccess', compact('sewa'));})->name('checkout.success');

    // STATUS SEWA
    Route::get('/cart/status/{status?}', [CartController::class, 'status'])->name('cart.status');
    Route::get('/cart/detail/{id}', [CartController::class, 'detail'])->name('cart.detail');
    Route::post('/cart/complete/{id}', [CartController::class, 'complete'])->name('cart.complete');
    Route::post('/cart/cancel/{id}', [CartController::class, 'cancel'])->name('cart.cancel');
    Route::get('/testimoni/create/{sewa}', [TestimoniController::class, 'create'])->name('user.testimoni.create');
    Route::post('/testimoni/{sewa}', [TestimoniController::class, 'store'])->name('user.testimoni.store');
    Route::get('/testimoni/{sewa}', [TestimoniController::class, 'show'])->name('user.testimoni.show');

    // CHAT
    Route::get('/chat', [UserController::class, 'chat'])->name('user.chat');
    Route::get('/chat/messages/{adminId}', [ChatController::class, 'fetchUserMessages'])->name('user.chat.messages');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('user.chat.send');
    Route::get('/chat/order/{sewa}', [ChatController::class, 'chatOrder'])->name('chat.order');

    // NOTIFIKASI (TANPA MIDDLEWARE)
    Route::get('/notifikasi', function () {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();
        $user->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('user.notifikasi', compact('notifications'));
    })->name('user.notifikasi');
});

/*
|--------------------------------------------------------------------------
| ADMIN - WAJIB LOGIN & ROLE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/data', [AdminController::class, 'dashboardData'])->name('admin.dashboardData');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');


    // PRODUK
    Route::get('/produk', [AdminProdukController::class, 'produk'])->name('admin.produk');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('admin.editProduk');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');

    // EVENT
    Route::get('/event', [EventAdminController::class, 'index'])->name('admin.event.index');
    Route::get('/event/create', [EventAdminController::class, 'create'])->name('admin.event.create');
    Route::post('/event', [EventAdminController::class, 'store'])->name('admin.event.store');
    Route::get('/event/{id}/edit', [EventAdminController::class, 'edit'])->name('admin.event.edit');
    Route::put('/event/{id}', [EventAdminController::class, 'update'])->name('admin.event.update');
    Route::delete('/event/{id}', [EventAdminController::class, 'destroy'])->name('admin.event.destroy');

    // PESANAN
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    Route::post('/pesanan/{id}/status', [AdminController::class, 'updateStatusPesanan'])->name('admin.pesanan.updateStatus');
    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian.index');
    Route::get('pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('admin.pengembalian.edit');
    Route::put('pengembalian/{id}', [PengembalianController::class, 'update'])->name('admin.pengembalian.update');

    // CHAT ADMIN
    Route::get('/pesan', [AdminController::class, 'pesan'])->name('admin.pesan');
    Route::get('/chat/users', [ChatController::class, 'getChatUsers'])->name('admin.chat.users');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'fetchAdminMessages'])->name('admin.chat.messages');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('admin.chat.send');
    Route::get('/iot-control', function() {
        return view('admin.iotControl');})->name('admin.iotControl');
});

/*
|--------------------------------------------------------------------------
| IoT / RFID (TETAP)
|--------------------------------------------------------------------------
*/
Route::get('/control-led/{command}', function ($command) {
    $valid = ['naruto', 'sasuke', 'sakura', 'off'];
    if (!in_array(strtolower($command), $valid)) {
        return response()->json(['response' => 'Invalid command']);
    }

    $url = 'http://10.230.141.139/control?command=' . $command;
    $context = stream_context_create(['http' => ['timeout' => 1]]);
    $response = @file_get_contents($url, false, $context);

    return response()->json(['response' => $response ?: 'ESP32 tidak merespon']);
});

Route::get('/rfid-scan', function () {
    if ($cached = Cache::get('rfid_data')) {
        return response()->json($cached);
    }

    $url = 'http://10.230.141.139/rfid-scan';
    $context = stream_context_create(['http' => ['timeout' => 0.5]]);
    $response = @file_get_contents($url, false, $context);

    $json = $response ? json_decode($response, true) : ['tag' => null, 'kostum' => null];
    Cache::put('rfid_data', $json, 3);

    return response()->json($json);
});



//footer link

Route::view('/faq', 'user.faq')->name('faq');
Route::view('/cararental', 'user.rental')->name('rental');
Route::view('/denda', 'user.denda')->name('denda');
Route::view('/refund', 'user.refund')->name('refund');
Route::view('/pengembalian', 'user.pengembalian')->name('pengembalian');
Route::view('/persyaratan', 'user.persyaratan')->name('persyaratan');



