<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $forUserId;

    public function __construct(Message $message, $forUserId)
    {
        $this->message = $message;
        $this->forUserId = $forUserId;
    }

    public function broadcastOn()
    {
        // Kirim ke channel khusus untuk user tertentu
        return new PrivateChannel('chat.user.' . $this->forUserId);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'sender_avatar' => $this->message->sender->avatar,
            'receiver_id' => $this->message->receiver_id,
            'body' => $this->message->body,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'read' => $this->message->read
        ];
    }

    public function broadcastAs()
    {
        return 'ChatMessageSent';
    }
}