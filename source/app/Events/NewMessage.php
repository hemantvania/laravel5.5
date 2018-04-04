<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Message;
class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $threadid;
    public $sendername;
    public $senderid;
    public $senderrole;
    public $created_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($threadid,$message,$sendername,$sender_id,$sender_role = "",$created_at)
    {
        //
        $this->message  = $message;
        $this->threadid = $threadid;
        $this->sendername = $sendername;
        $this->senderid = $sender_id;
        if(!empty($sender_role)) {
            $this->senderrole = $sender_role;
        }
        $this->created_at = $created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('vdesk-chat:'.$this->threadid);
    }
}
