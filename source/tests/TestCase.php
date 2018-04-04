<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    use CreatesApplication;

    protected $user;

    public function signIn($user = null ,$userrole = 0)
    {
        if(! $user) {
            $this->user = factory(\App\User::class)->create();

            if($userrole > 0 ) {
                $loginUser = User::find($this->user->id);
                $loginUser->userrole = $userrole;
                $loginUser->save();
            }
        }
        else
        {
            $this->user = $user;
        }

        // login with fake user
        $this->actingAs($this->user);

        return $this;
    }
}
