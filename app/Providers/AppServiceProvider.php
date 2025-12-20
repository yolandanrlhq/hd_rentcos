<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Cart;
use App\Models\CartItem;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {

            $userId  = Auth::id();
            $adminId = 1;

            // 🔔 NOTIFIKASI (LONCENG)
            $unreadCount = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->count();

            // 💬 CHAT (PESAN DARI ADMIN)
            $unreadChatCount = Message::where('receiver_id', $userId)
                ->where('sender_id', $adminId)
                ->where('is_read', false)
                ->count();


                // 🛒 CART (INI YANG KURANG)
            $cart = Cart::where('user_id', $userId)
                ->where('status', 'pending')
                ->first();

            $cartCount = $cart
                ? CartItem::where('cart_id', $cart->id)->sum('jumlah')
                : 0;


            // KIRIM KE SEMUA VIEW
            $view->with([
                'unreadCount'     => $unreadCount,
                'unreadChatCount' => $unreadChatCount,
                'cartCount'       => $cartCount,



            ]);
        }
    });
}

}
