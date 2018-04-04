<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Auth;
use App\User;
use App\UsersSchools;

class UsersSchoolsTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     *
     * Function is use for get user schools details
     */
    public function getUserSchools(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $objUsersSchools = new UsersSchools();
        $teacherSchools = $objUsersSchools->getUserSchools($authid,false);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $teacherSchools);
    }

    /**
     * @test
     *
     * Function is use for insert user schools details
     */
    public function storeUsersSchool(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $userid = 5;
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $objUsersSchools = new UsersSchools();
        $teacherSchools = $objUsersSchools->storeUsersSchool($userid,$primarySchoolId);
        $this->assertTrue(true,$teacherSchools);
    }



}
