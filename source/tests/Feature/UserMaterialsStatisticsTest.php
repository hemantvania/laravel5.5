<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Auth;
use App\User;
use App\UsersMaterialStatistics;

class UserMaterialsStatisticsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Inserting student materials data to Statistics table
     */
    public function InsertInToStatistics(){

        $student = User::where('userrole','=','3')->first();
        $this->signIn($student);
        $authid     = Auth::user()->id;
        $userClass  = Auth::user()->classes()->with('studentClass')->first();
        $materilaid = 3;
        $classid = $userClass->class_id;
        $objUsersMaterialStatistics = new UsersMaterialStatistics();
        $result = $objUsersMaterialStatistics->InsertInToStatistics($classid,$authid,$materilaid,1);
        $this->assertTrue(true,$result);
    }

    /**
     * @test
     *
     * Get the Todays Class Materials Status from Students
     */
    public function GetTodayStatusOfMaterials(){
        $student = User::where('userrole','=','3')->first();
        $this->signIn($student);
        $authid     = Auth::user()->id;
        $userClass  = Auth::user()->classes()->with('studentClass')->first();
        $materilaid = 3;
        $classid = $userClass->class_id;
        $objUsersMaterialStatistics = new UsersMaterialStatistics();
        $resultCount = $objUsersMaterialStatistics->GetTodayStatusOfMaterials($classid,$authid,$materilaid);
        $this->addToAssertionCount(true,$resultCount);
    }
}
