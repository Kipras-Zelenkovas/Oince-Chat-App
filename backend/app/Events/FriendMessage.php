<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $message_to;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, $message, $message_to)
    {
        $this->message = $message;
        $this->message_to = $message_to;
        $this->user = $user->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user/message' . $this->message_to),
        ];
    }

    public function broadcastAs(): string
    {
        return 'friend.message';
    }
}
