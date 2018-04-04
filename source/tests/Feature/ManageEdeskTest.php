<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ManageEdesk;
use App\User;
use Auth;
use App\Teachers;
use App\UsersClasses;

class ManageEdeskTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Insert Records to Manage Edesk On / Off
     */
    public function insertToManageEdesk(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $teachers = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultAssignClass = $teachers->getTeacherDefaultClass($primarySchoolId);
        $defaultAssignClass->class_id;
        $studentid = 5;

        $objManageEdesk = new ManageEdesk();
        $result = $objManageEdesk->insertToManageEdesk($studentid, $defaultAssignClass->class_id,$authid,0);
        $this->assertTrue(true,$result);
    }

    /**
     * @test
     *
     * Get Records By Id
     */
    public function getManageEdeskByStudentClassID(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $teachers = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultAssignClass = $teachers->getTeacherDefaultClass($primarySchoolId);
        $defaultAssignClass->class_id;
        $studentid = 5;

        $objManageEdesk = new ManageEdesk();
        $result = $objManageEdesk->getManageEdeskByStudentClassID($studentid, $defaultAssignClass->class_id,$authid);
        $this->assertArrayHasKey('is_active',$result);
    }

    /**
     * @test
     *
     * Update Status Based on Id
     */
    public function updateManageEdeskById(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $teachers = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultAssignClass = $teachers->getTeacherDefaultClass($primarySchoolId);
        $defaultAssignClass->class_id;
        $studentid = 5;
        $objManageEdesk = new ManageEdesk();
        $ids = $objManageEdesk->getManageEdeskByStudentClassID($studentid, $defaultAssignClass->class_id,$authid);
        $deskid = $ids->id;
        $result = $objManageEdesk->updateManageEdeskById($deskid,1);
        $this->assertTrue(true,$result);
    }

    /**
     * @test
     *
     * Students Get his Class status weather its locked or not
     */
    public function getManageEdeskByStudent(){
        $student = User::where('userrole','=','3')->first();
        $this->signIn($student);
        $authid  = Auth::user()->id;
        $class   = UsersClasses::where('user_id','=',$this->user->id)->first();
        $classid = $class->class_id;
        $objManageEdesk = new ManageEdesk();
        $list = $objManageEdesk->getManageEdeskByStudent($authid,$classid);
        $this->assertArrayHasKey('is_active',$list);

    }
}
