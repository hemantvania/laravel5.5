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

class ThreadParticipantsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * For thread check if the ids having some thread or not.
     */
    public function CheckThreadParticipant(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid  =  Auth::user()->id;
        $threadP = new ThreadParticipant();
        $ids     = '5,'.$authid;
        $result  = $threadP->checkThreadParticipant($ids);
        $this->addToAssertionCount($result);
    }

    /**
     * @test
     *
     * Get thread id of the teacher id 4 and student id 5
     */
    public function GetThreadId(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid  =  Auth::user()->id;
        $threadP = new ThreadParticipant();
        $ids     = '5,'.$authid;
        $result  = $threadP->getThreadId($ids);
        $this->assertArrayHasKey('thread_id',$result);

    }

    /**
     * @test
     *
     * Assign Users in Thread for the chat user
     */
    public function assignParticipantInThread(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid   =  Auth::user()->id;
        $threadP  = new ThreadParticipant();
        $ids      = '5,'.$authid;
        $thread   = new Thread();
        $threadid = $thread->createThread($authid);
        $threadPId  = $threadP->assignParticipantInThread($ids,$threadid);
        $this->assertTrue(true,$threadPId);
    }

    /**
     * @test
     *
     * Get All Thread by User ID
     */
    public function getAllThreadIdForUser(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid   =  Auth::user()->id;
        $threadP  = new ThreadParticipant();
        $allthrestids = $threadP->getAllThreadIdForUser($authid);
        $this->assertArrayHasKey('thread_id',$allthrestids[0]);
    }
}
