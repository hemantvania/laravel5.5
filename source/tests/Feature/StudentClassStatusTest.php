<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\StudentClassStatus;
use App\User;
use Auth;

class StudentClassStatusTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     *
     * Set the Class status completed by student
     */
    public function setClassCompleted(){
        $student = User::where('userrole','=','3')->first();
        $this->signIn($student);
        $studentid =  Auth::user()->id;
        $userClass = Auth::user()->classes()->with('studentClass')->first();
        $objStudentClassStatus = new StudentClassStatus();
        $list = $objStudentClassStatus->setClassCompleted($userClass['class_id']);
        $this->assertTrue(true,$list);
    }

    /**
     * @test
     *
     * Get the First records of the class with user id
     */
    public function isCompletedClass(){
        $student = User::where('userrole','=','3')->first();
        $this->signIn($student);
        $studentid =  Auth::user()->id;
        $userClass = Auth::user()->classes()->with('studentClass')->first();
        $objStudentClassStatus = new StudentClassStatus();
        $list = $objStudentClassStatus->isCompletedClass($userClass['class_id'],$studentid);
        if(!empty($list)){
            $this->assertArrayHasKey('class_id',$list);
        }
    }
}
