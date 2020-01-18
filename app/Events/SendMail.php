<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;  

class SendMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userIds;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userIds,$message)
    {
         $this->userIds = $userIds;
         $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
         return [];
    }
}
