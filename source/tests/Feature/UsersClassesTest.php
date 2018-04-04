<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Auth;
use App\UsersClasses;

class UsersClassesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Assign students to specific class with students array
     */
    public function assignClass(){

        $schooladmin = User::where('userrole','=','6')->first();
        $this->signIn($schooladmin);
        $authid     = Auth::user()->id;
        $classid    = 2;
        $users      = array(2,3,4);
        $objUsersClasses = new UsersClasses();
        $rs = $objUsersClasses->assignClass($users,$classid);
        $this->assertTrue(true,$rs);
    }

    /**
     * @test
     *
     * Return all assigned teachers in a class by class id
     */
    public function getTeachersOfClass(){
        $schooladmin = User::where('userrole','=','6')->first();
        $this->signIn($schooladmin);
        $authid     = Auth::user()->id;
        $classid    = 2;
        $objUsersClasses = new UsersClasses();
        $classlist = $objUsersClasses->getTeachersOfClass($classid);
        $this->assertInternalType("int", $classlist[0]);
    }

    /**
     * @test
     *
     * Return Total Number of count for specific user assign to specific class
     */
    public function getAssignStudentCount(){
        $schooladmin = User::where('userrole','=','6')->first();
        $this->signIn($schooladmin);
        $authid     = Auth::user()->id;
        $studentid    = 4;
        $objUsersClasses = new UsersClasses();
        $totalcount = $objUsersClasses->getAssignStudentCount($studentid);
        $this->assertInternalType("int", $totalcount);
    }

    /**
     * @test
     *
     * Assign Student To Specific Class
     */
    public function assignStudent(){
        $schooladmin = User::where('userrole','=','6')->first();
        $this->signIn($schooladmin);
        $authid     = Auth::user()->id;
        $classid    = 2;
        $users      = 3;
        $objUsersClasses = new UsersClasses();
        $rs = $objUsersClasses->assignStudent($users,$classid,0);
        $this->assertTrue(true,$rs);
    }

    /**
     * @test
     *
     * Get the class max sequence
     */
    public function getClassLastSequence(){
        $classid    = 2;
        $objUsersClasses = new UsersClasses();
        $sequence = $objUsersClasses->getClassLastSequence($classid);
        $this->assertInternalType("int",$sequence);
    }
}
