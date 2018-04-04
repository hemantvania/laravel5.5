<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Thread;
use App\User;
use Auth;
use App\ThreadParticipant;
use App\Message;

class ThreadMessageTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * @test
     *
     * Get the Messages From Thread id
     */
    public function GetThreadMessages(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid  =  Auth::user()->id;
        $threadP = new ThreadParticipant();
        $ids     = '5,'.$authid;
        $result  = $threadP->getThreadId($ids);
        $threadid = $result['thread_id'];
        $objmessage = new Message();
        $message    = $objmessage->getThreadMessages($threadid);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $message);
    }

    /**
     * @test
     *
     * Sending messages in thread
     */
    public function SendThreadMessage(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid  =  Auth::user()->id;
        $threadP = new ThreadParticipant();
        $ids     = '5,'.$authid;
        $result  = $threadP->getThreadId($ids);
        $threadid = $result['thread_id'];
        $message  = 'Hi this is tesitng from teacher';
        $objmessage = new Message();
        $messageid  = $objmessage->sendThreadMessage($threadid,$message);
        $this->assertInternalType("int", $messageid);
    }

    /**
     * @test
     *
     * Get No of users which are in threads
     */
    public function getChatUsers(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid  =  Auth::user()->id;
        $threadP = new ThreadParticipant();
        $ids     = '5,'.$authid;
        $objmessage = new Message();
        $chatusers  = $objmessage->getChatUsers($ids);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $chatusers);
    }
}
