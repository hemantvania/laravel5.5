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
class StudentStatus implements ShouldBroadcastNow
{
    use SerializesModels;

    public $studentid = '';
    public $classid = '';
    public $student_name = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($studentsid,$classid,$student_name)
    {
        //
        $this->classid = $classid;
        $this->studentid = $studentsid;
        $this->student_name = $student_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('vdesk-channel');
    }
}
