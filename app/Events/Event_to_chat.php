<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;

class Event_to_chat extends Event implements ShouldBroadcast
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;

    public function __construct($data)
    {
        //
        $this->message = $data;
    }

    public function broadcastOn()
    {
        return ['chat'];
        // TODO: Implement broadcastOn() method.
    }
}
