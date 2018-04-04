<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laracasts\Integrated\Extensions\Laravel;
use Auth;
use App\User;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function is_load_students_home_page()
    {
        //Create fake user
        $student = factory(\App\User::class)->create();

        // Change userrole to student on created user
        $user = User::find($student->id);
        $user->userrole = 3;
        $user->save();

        // login with fake user
        Auth::login($student);
//        echo Auth::user()->name ; die();
     //   $this->visit('/')->see('MATERIAL NAME');
        //$this->call('GET', '/');
       /* $this->browse(function ($browser) {
            $browser->visit('/')
                -> assertSee('MATERIAL NAME');
        });*/
    }
}
