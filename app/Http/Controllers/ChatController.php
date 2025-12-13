<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function fetchUserMessages()
    {
        $userId  = Auth::id();
        $adminId = 1;

        $messages = Message::where(function($q) use($userId, $adminId){
            $q->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function($q) use($userId, $adminId){
            $q->where('sender_id', $adminId)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($msg) {
            return [
                'id'          => $msg->id,
                'sender_id'   => $msg->sender_id,
                'receiver_id' => $msg->receiver_id,
                'message'     => $msg->message,
                'time'        => $msg->created_at->format('H:i'),
            ];
        });

        return response()->json($messages);
    }

    public function fetchAdminMessages($userId)
    {
        $adminId = 1;

        $messages = Message::where(function($q) use($userId, $adminId){
            $q->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orWhere(function($q) use($userId, $adminId){
            $q->where('sender_id', $userId)->where('receiver_id', $adminId);
        })
        ->orderBy('created_at', 'asc')
        ->with('sender:id,name,foto') // ambil relasi sender
        ->get()
        ->map(function($msg){
            return [
                'id'          => $msg->id,
                'sender_id'   => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'Unknown', 
                'sender_foto' => $msg->sender->foto ?? null, 
                'receiver_id' => $msg->receiver_id,
                'message'     => $msg->message,
                'time'        => $msg->created_at->format('H:i'),
                'created_at'  => $msg->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'message'     => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'data' => [
                'id'      => $message->id,
                'message' => $message->message,
            ]
        ]);
    }

    public function getChatUsers()
    {
        $users = \App\Models\User::where('id', '!=', 1) // kecuali admin
                    ->select('id', 'name', 'foto')
                    ->orderBy('name', 'asc')
                    ->get();

        return response()->json($users);
    }
}
