<?php

namespace Tests\Feature;

use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Students;
use Illuminate\Database\Eloquent\Collection;
use App\ClassMaterials;
use App\Classes;
use App\Material;
use App\UsersClasses;

class StudentsTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * @test
     * Testing of students list get when school admin logged in
     */
    public function getStudentList()
    {
        //get school admin to auth login
        $admin = User::where('userrole','=','6')->first();
        $this->signIn($admin);

        $studentObj = new Students();

        $list = $studentObj->getStudentList();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $list);

    }

    /**
     * @test
     * Testing of get assigned materials to class after student logged in
     */
    public function getMaterialList()
    {
        // create fake student and login with them
        $this->signIn(null,3);

        //  create fake class
        $classid = factory(\App\Classes::class)->create()->id;
        // create fake material
        $materilid = factory(\App\Material::class)->create()->id;

        // Assign material to class
        $assignMaterial = new ClassMaterials();
        $assignMaterial->assignClassMaterials($classid,$materilid);

        // Assign Student to class
        $assignClass = new UsersClasses();
        $assignClass->assignStudent($this->user->id,$classid,1);

        // get material list
        $studentObj = new Students();
        $materials = $studentObj->getMaterialList();

        $this->assertArrayHasKey('materialName',$materials[0]);
    }

    /**
     * @test
     * Testing of edesk listing on associated class which student has assigned
     */
    public function getStudentEdeskListByClass()
    {
        // get student from database
        $student = User::where('userrole','=','3')->first();

        $this->signIn($student);

        $class = UsersClasses::where('user_id','=',$this->user->id)->first();

        $studentObj = new Students();
        $edskList = $studentObj->getStudentEdeskListByClass($class->class_id);

        $this->assertArrayHasKey('class_id',$edskList[0]);
    }
}
