<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Thread;
use App\User;
use Auth;

class ThreadTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Creating New Thread When Chat is initiated
     */
    public function CreateThread(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $thread = new Thread();
        $result = $thread->createThread($authid);
        $expectedResult = true;
        $this->assertEquals($expectedResult,$result);
    }
}
