<?php

namespace App\Events;

use App\ChatMessages;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $participant1;
    public $participant2;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $participant1, User $participant2, ChatMessages $message)
    {
        $this->participant1 = $participant1;
        $this->participant2 = $participant2;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel("chat.{$this->participant2->id}");
    }

    public function broadcastAs()
    {
        return 'messagesent';
    }
}
