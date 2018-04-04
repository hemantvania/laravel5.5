<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
class Thread implements ShouldBroadcastNow
{
    use SerializesModels;

    public $threadid;
    public $userid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($threadid,$userid)
    {
        $this->threadid = $threadid;
        $this->userid   = $userid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('vdesk-thread:'.$this->userid);
    }
}
