<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class StartClass implements ShouldBroadcastNow
{
    use SerializesModels ;

    public $classid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($classid)
    {
        //
        $this->classid = $classid;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
       // return new PrivateChannel('test-channel');
        //return new Channel('class-channel-'.$this->classid);
        return new Channel('vdesk-channel');


    }
}
