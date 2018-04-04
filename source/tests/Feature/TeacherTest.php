<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Testing;
use App\Thread;
use App\ThreadParticipant;
use App\User;
use Auth;
use App\Message;
use App\Material;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use App\Teachers;

class TeacherTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Get the list of materials which is uploded by admin and logged in teacher
     */
    public function GetMaterialsList(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $objMaterial = new Material();
        $materials   = $objMaterial->getMaterialList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $materials);
    }

    /**
     * @test
     *
     * Fetching the notification list of logged in teacher
     */
    public function getTeacherNotificationList(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $teachers       = new Teachers();
        $notifications  = $teachers->getTeachersStudentNotification($primarySchoolId);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $notifications);
    }

    /**
     * @test
     *
     * Fetching the all teachers list
     */
    public function getTeacherList(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $teacherslist  = $teachers->getTeacherList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $teacherslist);
    }

    /**
     * @test
     *
     * List out the logged in Teacher Schools First Record
     */
    public function getTeacherSchools(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $teachersSchoollist  = $teachers->getTeacherSchools(false);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $teachersSchoollist);
    }

    /**
     * @test
     *
     * Returns Teacher's Primary school details
     */
    public function getTeachersPrimarySchool(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $teachersSchools  = $teachers->getTeachersPrimarySchool();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $teachersSchools);
    }

    /**
     * @test
     *
     * List all classes from school id
     */
    public function getSchoolClasses(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $classlist = $teachers->getSchoolClasses($primarySchoolId);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $classlist);
    }

    /**
     * @test
     *
     * List all students in the current selected class
     */
    public function getAssignStudentsInClass(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultAssignClass = $teachers->getTeacherDefaultClass($primarySchoolId);
        if(!empty($defaultAssignClass)){
            $studentslist = $teachers->getAssignStudentsInClass($defaultAssignClass->class_id);
        } else {
            $studentslist = array();
        }
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $studentslist);
    }

    /**
     * @test
     *
     * List all students from logged in teacher's schools
     */
     public function getSchoolUserList(){
         $teacher = User::where('userrole','=','2')->first();
         $this->signIn($teacher);
         $teachers       = new Teachers();
         $primarySchoolId = Auth::user()->userMeta->default_school;
         if(empty($primarySchoolId)) {
             $teachers = new Teachers();
             $schoolinfo = $teachers->getTeacherSchools(true);
             if(!empty($schoolinfo)){
                 $primarySchoolId = $schoolinfo->school_id;
             }
         }
        $schoolUseList =  $teachers->getSchoolUserList($primarySchoolId);
         $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $schoolUseList);
     }

    /**
     * @test
     *
     * Get All Classes Assign to logged in Teacher
     */
    public function getTeacherAssignClasses(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $assignClasses =  $teachers->getTeacherAssignClasses($primarySchoolId);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $assignClasses);
    }

    /**
     * @test
     *
     * Fetching the default class for the logged in teacher
     */
    public function getTeacherDefaultClass(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses =  $teachers->getTeacherDefaultClass($primarySchoolId);
        $this->assertArrayHasKey('class_id',$defaultClasses);
    }

    /**
     * @test
     *
     * Get Logged in teachers school information
     */
    public function getSchoolInfo(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $schoolInfo =  $teachers->getSchoolInfo($primarySchoolId);
        $this->assertArrayHasKey('schoolName',$schoolInfo);
    }
}
