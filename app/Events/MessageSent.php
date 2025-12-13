<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = [
            'id'          => $message->id,
            'sender_id'   => $message->sender_id,
            'sender_name' => $message->sender->name,
            'sender_foto' => $message->sender->foto,
            'receiver_id' => $message->receiver_id,
            'message'     => $message->message,
            'time'        => $message->created_at->format('H:i'),
        ];
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message['receiver_id']);
    }

    public function broadcastWith()
    {
        // kembalikan array lengkap
        return $this->message;
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}