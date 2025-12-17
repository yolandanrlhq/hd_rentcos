<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Sewa;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // =====================
    // LOGIN GUARD
    // =====================
    private function mustLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return null;
    }

    // =====================
    // USER → FETCH CHAT
    // =====================
    public function fetchUserMessages()
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $userId  = Auth::id();
        $adminId = 1;

        $messages = Message::where(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'receiver_id' => $m->receiver_id,
                'message' => $m->message,
                'time' => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }

    // =====================
    // ADMIN → FETCH CHAT
    // =====================
    public function fetchAdminMessages($userId)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $adminId = 1;

        if (Auth::id() !== $adminId) {
            abort(403);
        }

        $messages = Message::where(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->with('sender:id,name,foto')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'sender_name' => $m->sender->name ?? 'Unknown',
                'sender_foto' => $m->sender->foto ?? null,
                'receiver_id' => $m->receiver_id,
                'message' => $m->message,
                'time' => $m->created_at->format('H:i'),
                'created_at' => $m->created_at->format('Y-m-d H:i:s'),
            ]);

        return response()->json($messages);
    }

    // =====================
    // SEND MESSAGE
    // =====================
    public function send(Request $request)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
            ]
        ]);
    }

    // =====================
    // ADMIN → LIST USERS
    // =====================
    public function getChatUsers()
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return response()->json(
            \App\Models\User::where('id', '!=', 1)
                ->select('id', 'name', 'foto')
                ->orderBy('name')
                ->get()
        );
    }

    // =====================
    // CHAT BERDASARKAN SEWA
    // =====================
    public function orderChat($sewaId)
    {
        if ($redirect = $this->mustLogin()) return $redirect;

        $sewa = Sewa::with(['items.produk', 'user', 'cart'])->findOrFail($sewaId);

        if ($sewa->user_id !== Auth::id()) {
            abort(403);
        }

        if (!Message::where('sewa_id', $sewa->id)->exists()) {
            $text  = "📦 DETAIL PESANAN\n";
            $text .= "--------------------------\n";
            $text .= "Nama        : {$sewa->user->name}\n";
            $text .= "Pengiriman  : {$sewa->cart->delivery_method}\n\n";
            $text .= "Daftar Item:\n";

            foreach ($sewa->items as $item) {
                $text .= "- {$item->produk->nama_produk} ({$item->jumlah}x)\n";
            }

            $text .= "\n--------------------------\n";
            $text .= "Total : Rp" . number_format($sewa->total_harga, 0, ',', '.');

            Message::create([
                'sewa_id' => $sewa->id,
                'sender_id' => $sewa->user_id,
                'receiver_id' => 1,
                'message' => $text,
            ]);
        }

        $messages = Message::where('sewa_id', $sewa->id)
            ->orderBy('created_at')
            ->get();

        return view('user.pesan', compact('sewa', 'messages'));
    }
}
