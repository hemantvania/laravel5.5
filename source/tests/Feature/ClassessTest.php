<?php

namespace Tests\Feature;

use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Classes;


class ClassessTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function addClassAdmin()
    {
        $class = factory(\App\Classes::class)->create();
        $classData = array(
            'className' => $class->className,
            'schoolId' => $class->schoolId,
            'educationTypeId' => $class->educationTypeId,
            'standard' => $class->standard,
            'class_duration' => $class->class_duration,
            'class_size' =>  $class->class_size,
        );

        $classObj = new Classes();
        $addClass = $classObj->addClassAdmin($classData);


        $this->assertEquals(true,$addClass);

    }
    /**
     * @test
     */
    public function checkRecordExist()
    {
        $class = factory(\App\Classes::class)->create();
        $classObj = new Classes();
        $addClass = $classObj->checkRecordExist($class->id);

        $this->assertEquals(true,$addClass);
    }

    /**
     * @test
     */
    public function deleteClass()
    {
        $class = factory(\App\Classes::class)->create();
        $classObj = new Classes();
        $addClass = $classObj->deleteClass($class->id);

        $this->assertEquals(true,$addClass);
    }
}
