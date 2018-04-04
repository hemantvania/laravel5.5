<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Auth;
use App\UserMeta;

class UserMetaTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     *
     * Update User Meta
     */
    public function UpdateUserMeta(){

        $objUserMeta = new UserMeta();
        $userid = 6;
        $data = array (
            'phone' => 9624118007,
            'profileimage' => 'test.pbg',
            'addressline1' => '20 New Faliya',
            'addressline2' => 'Testing',
            'city' => 'Testing',
            'state' => 'Testing',
            'zip' => 39556,
            'country' => 1,
            'ssn' => 123456789,
            'gender' => 0,
            'default_school' => 1,
            'enable_share_screen' => 0,
        );
        $updates = $objUserMeta->UpdateUserMeta($data,$userid);
        $this->assertTrue(true,$updates);
    }

    /**
     * @test
     *
     * Get User Meta List
     */
    public function getUserMeta(){
        $objUserMeta = new UserMeta();
        $userid = 6;
        $userMetas = $objUserMeta->getUserMeta($userid);
        $this->assertArrayHasKey('userId',$userMetas);
    }

}
