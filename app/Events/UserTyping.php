<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $receiverSessionId;

    /**
     * Create a new event instance.
     */
    public function __construct($username, $receiverSessionId = null)
    {
        $this->username = $username;
        $this->receiverSessionId = $receiverSessionId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        if ($this->receiverSessionId) {
            return [
                new PrivateChannel('chat.' . $this->receiverSessionId),
            ];
        }
        
        return [
            new Channel('global-chat'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'username' => $this->username,
        ];
    }
}
