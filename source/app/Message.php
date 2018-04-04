<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'thread_id', 'message', 'sender_id','created_at'
    ];

    /**
     * Get all messages from the thread id
     * @param $threadid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThreadMessages($threadid)
    {
        return self::join('users', 'sender_id', '=', 'users.id')
            ->select('*','messages.created_at')
            ->where('thread_id', '=', $threadid)
            ->orderBy('messages.id')
            ->get();
    }

    /**
     * Create New Message
     * @param $thredid
     * @param $message
     * @return int
     */
    public function sendThreadMessage($thredid, $message)
    {
        $authid = Auth()->id();
        $res = self::insertGetId([
            'thread_id' => $thredid,
            'message' => $message,
            'sender_id' => $authid,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
        return $res;
    }

    /**
     * Get No of users which are in threads
     * @param $ids
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getChatUsers($ids)
    {
        return User::select('*')
            ->whereIn('id', [$ids])
            ->get();
    }

}
