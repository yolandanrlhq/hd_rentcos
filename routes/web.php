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

        // Status rented costumes
        Route::get('/status', [CartController::class, 'status'])->name('cart.status');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post');

        Route::get('/sewa', [CartController::class, 'sewa'])->name('cart.sewa');
    });


    Route::get('/jadwalEvent', function () {
        return view('user.jadwalEvent');
    })->name('user.jadwalEvent');
    Route::get('/wishlist', function () {
        return view('user.wishlist');
    })->name('user.wishlist');


// ===================== LED CONTROL =====================
Route::get('/control-led', function () {
    $command = request('command');  // Mendapatkan perintah dari input teks

    $validCommands = ['naruto', 'sasuke', 'sakura'];

    if (!$command || !in_array(strtolower($command), $validCommands)) {
        return view('control', ['response' => 'Invalid command! Please try again.']);
    }

    $esp32_ip = 'http://10.230.141.139/control?command=' . $command;
    $response = file_get_contents($esp32_ip);

    return view('control', ['response' => $response]);
});

Route::get('/control-led/{command}', function ($command) {
    $validCommands = ['naruto', 'sasuke', 'sakura', 'off'];

    if (!in_array(strtolower($command), $validCommands)) {
        return response()->json(['response' => 'Invalid command!']);
    }

    $esp32_ip = 'http://10.230.141.139/control?command=' . $command;
$response = file_get_contents($esp32_ip);

// ambil teks status LED saja
preg_match('/<p><b>Status LED:<\/b>\s*(.*?)<\/p>/', $response, $matches);
$status = $matches[1] ?? 'Status tidak diketahui';

return response()->json(['response' => $status]);

});


// ===================== RFID SCAN =====================
// Endpoint baru untuk fetch data RFID dari ESP32
Route::get('/rfid-scan', function () {
    $esp32_ip = 'http://10.230.141.139/rfid-scan'; // endpoint Arduino JSON
    $response = file_get_contents($esp32_ip);      // ambil data dari ESP32
    return response()->json(json_decode($response));
});

// ===================== HALAMAN ADMIN IoT =====================
Route::get('/admin/iot-control', function () {
    return view('admin.iotControl');
})->name('admin.iotControl');
