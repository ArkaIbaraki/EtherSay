<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];
        
        // Jika private message, broadcast ke kedua user
        if ($this->message->receiver_session_id) {
            $channels[] = new PrivateChannel('chat.' . $this->message->sender_session_id);
            $channels[] = new PrivateChannel('chat.' . $this->message->receiver_session_id);
        } else {
            // Global chat
            $channels[] = new Channel('global-chat');
        }
        
        return $channels;
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_session_id' => $this->message->sender_session_id,
            'sender_username' => $this->message->sender_username,
            'receiver_session_id' => $this->message->receiver_session_id,
            'receiver_username' => $this->message->receiver_username,
            'message' => $this->message->message,
            'is_system_message' => $this->message->is_system_message,
            'is_read' => $this->message->is_read,
            'file' => $this->message->fileShare,
            'created_at' => $this->message->created_at->toIso8601String(),
        ];
    }
}
