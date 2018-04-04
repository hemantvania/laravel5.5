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

class StartScreenShare implements  ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userid = '';
    public $link = '';
    public $requestedBy = ''; // Name of requested by user
    public $isViwer = 'false';
    public $userRole = "";
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userid,$link,$requestedBy,$isViwer, $userRole)
    {
        $this->userid = $userid;
        $this->link = $link;
        $this->requestedBy = $requestedBy;
        $this->isViwer = $isViwer;
        $this->userRole = $userRole;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('vdesk-share:'.$this->userid);
    }
}
