<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Message;

class ThreadParticipant extends Model
{
    public $table = "threads_participants";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'thread_id', 'user_id', 'created_at', 'updated_at'
    ];

    /**
     * For thread check if the ids having some thread or not.
     * @param $ids
     * @return int
     */
    public function checkThreadParticipant($ids)
    {
        return self::join('threads', 'threads_participants.thread_id', '=', 'threads.id')
            ->where('user_id', '=', $ids)
            ->get()->count();
    }

    /**
     * Get the thread id
     * @param $ids
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThreadId($ids)
    {
        return self::join('threads', 'threads_participants.thread_id', '=', 'threads.id')
            ->where('user_id', '=', $ids)
            ->select('threads_participants.thread_id')->first();
    }

    /**
     * Assign Users in Thread for the chat user
     * @param $studentid
     * @param $threadid
     * @return bool
     */
    public function assignParticipantInThread($studentid, $threadid)
    {
        return self::insert(
            [
                'thread_id' => $threadid,
                'user_id' => $studentid,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }

    /**
     * Get All Thread by User ID
     * @param $userid
     * @return array
     */
    public function getAllThreadIdForUser($userid)
    {
        return self::join('threads', 'threads_participants.thread_id', '=', 'threads.id')
            ->where('user_id', 'like', '%' . $userid . '%')
            ->groupBy('threads_participants.thread_id')
            ->select('threads_participants.thread_id')->get()->toArray();
    }
}
