<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\School;

class SchoolDistrictTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Display Dashboard Schools
     */
    public function DashboardSchools(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $users =  new User();
        $totalUser = $users->getSchoolDistrictUsers();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $totalUser);
    }

    /**
     * @test
     *
     * Get total View Materials which is shared in schools of school district
     */
    public function DashboardViewMaterials(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school     = new School();
        $totalView  = $school->viewMaterialStatisticBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $totalView);
    }

    /**
     * @test
     *
     *  Get total Shared Materials which is shared in schools of school district
     */
    public function DashboardSharedMaterilas(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school     = new School();
        $totalShare = $school->shareMaterialStatisticBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $totalShare);
    }

    /**
     * @test
     *
     * Display total schools which is assign to logged in school district
     */
    public function SchoolList(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $schoollist   = $school->getSchoolListBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $schoollist);
    }

    /**
     * @test
     *
     * Display the teachers list which is assign to logged in shcool district
     */
    public function TeachersList(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $teacherlist   = $school->getTeachersListBySchools();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $teacherlist);
    }

    /**
     * @test
     *
     * List all the students which is assign to all schools of school district
     */
    public function StudentList(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $studentlist   = $school->getStudentsListBySchools();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $studentlist);
    }

    /**
     * @test
     * list out all the materials shared and vived in the assign school of school district
     */
    public function MaterilasList(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $materilaslist   = $school->getSharedMaterialsListBySchoolsClasses();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $materilaslist);
    }
}
