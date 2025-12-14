<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tambah notifikasi baru
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul'   => 'required|string',
            'pesan'   => 'required|string',
            'ikon'    => 'nullable|string',
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'judul'   => $request->judul,
            'pesan'   => $request->pesan,
            'ikon'    => $request->ikon,
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'data' => $notification]);
    }

    // Tampilkan semua notifikasi user
    public function getUserNotifications($user_id)
    {
        $user = User::findOrFail($user_id);
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return response()->json(['success' => true, 'data' => $notifications]);
    }

    // Tandai notifikasi terbaca
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }
}
