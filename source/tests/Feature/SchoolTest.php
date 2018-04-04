<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\School;
use App\User;
use Auth;
use App\Teachers;

class SchoolTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Get the students list
     */
    public function getList(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $role = Auth::user()->userrole;
        $objSchool = new School();
        $list = $objSchool->getList($authid,$role);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }

    /**
     * @test
     *
     * Check if the records are exist or not
     */
    public function checkRecordExist(){
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
        $objSchool = new School();
        $list = $objSchool->checkRecordExist($primarySchoolId);
        $this->assertTrue(true,$list);
    }

    /**
     * @test
     *
     * get school info by id
     */
    public function getSchoolById(){
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
        $objSchool = new School();
        $list = $objSchool->getSchoolById($primarySchoolId);
        $this->assertArrayHasKey('schoolName',$list);
    }

    /**
     * @test
     *
     * store school data
     */
    public function storeSchool(){


        $data = array(
            'schoolName'    => 'Testing',
            'email'         => 'test@test.com',
            'registrationNo'=> '123456789',
            'WebUrl'        => 'http://www.google.com',
            'address1'      => 'testing',
            'address2'      => 'testing',
            'city'          => 'Navsari',
            'state'         => 'Gujarat',
            'zip'           => '395689',
            'country'       => 1,
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'schoolType'    => ''
        );

        $objSchool  = new School();
        $schooldata = $objSchool->storeSchool($data);
        $this->assertInternalType("int", $schooldata);
    }

    /**
     * @test
     *
     * Function is use for update schools data
     */
    public function schoolUpdate(){

        $data = array(
            'schoolName'    => 'Testing',
            'email'         => 'test@test.com',
            'registrationNo'=> '123456789',
            'WebUrl'        => 'http://www.google.com',
            'address1'      => 'testing',
            'address2'      => 'testing',
            'city'          => 'Navsari',
            'state'         => 'Gujarat',
            'zip'           => '395689',
            'country'       => 1,
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'schoolType'    => ''
        );

        $objSchool  = new School();
        $schooldata = $objSchool->storeSchool($data);

        $data = array(
            'schoolName'    => 'Testing with JM',
            'email'         => 'test@test.com',
            'registrationNo'=> '123456789',
            'WebUrl'        => 'http://www.google.com',
            'address1'      => 'testing',
            'address2'      => 'testing',
            'city'          => 'Navsari',
            'state'         => 'Gujarat',
            'zip'           => '395689',
            'country'       => 1,
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'schoolType'    => ''
        );

        $schooldata = $objSchool->schoolUpdate($data,$schooldata);
        $this->assertTrue(true,$schooldata);
    }

    /**
     * @test
     *
     *  School Soft Delete
     */
    public function schoolDelete(){
        $data = array(
            'schoolName'    => 'Testing',
            'email'         => 'test@test.com',
            'registrationNo'=> '123456789',
            'WebUrl'        => 'http://www.google.com',
            'address1'      => 'testing',
            'address2'      => 'testing',
            'city'          => 'Navsari',
            'state'         => 'Gujarat',
            'zip'           => '395689',
            'country'       => 1,
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'schoolType'    => ''
        );

        $objSchool  = new School();
        $schooldata = $objSchool->storeSchool($data);
        $delschool = $objSchool->schoolDelete($schooldata);
        $this->assertTrue(true,$delschool);
    }

    /**
     * @test
     *
     * Restore School from soft delete
     */
    public function restoreRecord(){

        $data = array(
            'schoolName'    => 'Testing',
            'email'         => 'test@test.com',
            'registrationNo'=> '123456789',
            'WebUrl'        => 'http://www.google.com',
            'address1'      => 'testing',
            'address2'      => 'testing',
            'city'          => 'Navsari',
            'state'         => 'Gujarat',
            'zip'           => '395689',
            'country'       => 1,
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'schoolType'    => ''
        );

        $objSchool  = new School();
        $schooldata = $objSchool->storeSchool($data);
        $delschool  = $objSchool->schoolDelete($schooldata);
        $restore    = $objSchool->restoreRecord($schooldata);
        $this->assertTrue(true,$restore);
    }

    /**
     * @test
     *
     * Get School district shcool data
     */
    public function getSchoolDistrictByShoolId(){

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
        $objSchool  = new School();
        $schooldata = $objSchool->getSchoolDistrictByShoolId($primarySchoolId);
        $this->assertArrayHasKey('school_id',$schooldata);
    }


    /**
     * @test
     *
     * Get all school list for school district user
     */
    public function getSchoolListBySchoolDistrict(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $objSchool  = new School();
        $schooldata = $objSchool->getSchoolListBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $schooldata);
    }

    /**
     * @test
     *
     * Teachers List By schools
     */
    public function getTeachersListBySchools(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $teacherlist   = $school->getTeachersListBySchools();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $teacherlist);
    }

    /**
     * @test
     *
     * Get Students list
     */
    public function getStudentsListBySchools(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $studentlist   = $school->getStudentsListBySchools();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $studentlist);
    }

    /**
     * @test
     *
     * Get Materials Statistic
     */
    public function shareMaterialStatisticBySchoolDistrict(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $data   = $school->shareMaterialStatisticBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $data);
    }

    /**
     * @test
     *
     * Get View Materials Statistic
     */
    public function viewMaterialStatisticBySchoolDistrict(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $data   = $school->viewMaterialStatisticBySchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $data);
    }

    /**
     * @test
     *
     * Get Shared Materials List by schools
     */
    public function getSharedMaterialsListBySchoolsClasses(){
        $schoolDistrict = User::where('userrole','=','4')->first();
        $this->signIn($schoolDistrict);
        $school = new School();
        $data   = $school->getSharedMaterialsListBySchoolsClasses();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $data);
    }
}
