<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
    }

    /**
     * @test
     *
     * This case is use for success login
     */
    public function genralLoginSucess(){
        $userObj = new User();
        //with valid login detail
        $data=array(
            'email'=>"hardik.soni@gatewaytechnolabs.com",
            'password'=>"123456",
        );
        $result = $userObj->generalLogin($data);
        $expectedResult = true;
        $this->assertEquals($expectedResult,$result);
    }

    /**
     * @test
     *
     * This case is use for fail login
     */
    public function genralLoginFail(){
        $userObj = new User();
        //With invalid login detail
        $data=array(
            'email'=>"ravi.gadhiya@gatewaytechnolabs.com",
            'password'=>"12345678",
        );
        $result = $userObj->generalLogin($data);
        $expectedResult = false;
        $this->assertEquals($expectedResult,$result);
    }

    /**
     * @test
     *
     * GetUserList Method
     */
    public function GetUserList(){
        $userObj = new User();
        $users = $userObj->getUserList();
        $isUser = $users->first();
        $this->assertArrayHasKey('phone',$isUser); // test relation to by phone field
    }

    /**
     * @test
     *
     * Check getUserById method result must have email to be true
     */
    public function GetUserById(){
        $userObj = new User();
        $userDetails = $userObj->getUserById($this->user->id);
        $this->assertArrayHasKey('email',$userDetails);
    }

    /**
     * @test
     *
     * This is to update existing user data
     */
    public function UpdateUser(){
        $userObj = new User();
        $data=array(
                'name'          => $this->user->first_name,
                'last_name'     => $this->user->last_name,
                'email'         => $this->user->email,
                'userrole'      => $this->user->userrole,
             );
        $result = $userObj->updateUser($data,$this->user->id);
        $expectedResult = true;
        $this->assertEquals($expectedResult,$result);
    }

    /**
     * @test
     *
     * To get school district users list after school admin logged in
     */
    public function GetSchoolDistrictUsers(){
        // find admin id to login
          $admin = User::where('userrole','=','6')->first();
          $this->signIn($admin);
          $userObj = new User();
          $districts = $userObj->getSchoolDistrictUsers();
          $this->assertArrayHasKey('schoolName',$districts[0]);
    }

    /**
     * @test
     *
     * Test of deleteUser
     */
    public function DeleteUser(){
        $userObj = new User();
        $result = $userObj->deleteUser($this->user->id);
        $expectedResult = true;
        $this->assertEquals($expectedResult,$result);
    }

    /**
     * @test
     *
     * Of restore record method
     */
    public function RestoreRecord(){
        $userObj = new User();
        $userObj->deleteUser($this->user->id);
        $restore = $userObj->restoreRecord($this->user->id);
        $expectedResult = true;
        $this->assertEquals($expectedResult,$restore);
    }

    /**
     * @test
     *
     * Of create new user
     */
    public function CreateUserAdmin(){
        $userData = array(
            'name'  =>  'Test',
            'last_name'  =>  'Name',
            'userrole'  =>  '2',
            'email'  =>  str_random(5).'@vdesk.com',
            'password'  =>  '123456',
            'phone'  =>  random_int(10,10),
            'addressline1'  =>  str_random(10),
            'addressline2'  =>  str_random(15),
            'city'  =>  str_random(5),
            'zip'  =>  random_int(5,5),
            'country'  =>  1,
            'ssn'  =>  str_random(15),
            'gender'  =>  '1',
            'profileimage'  =>  '',
            'enable_share_screen'  =>  '1',
            'default_school'  =>  '1',
            'schoolId'  =>  array('1')
        );
        $userObj = new User();
        $create = $userObj->createUserAdmin($userData);
        $this->assertEquals(true,$create);
    }

    /**
     * @test
     *
     * get list of all school district user
     */
    public function getSchoolDistrict(){
        $objUser = new User();
        $districtlist = $objUser->getSchoolDistrict();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $districtlist);
    }

    /**
     * @test
     *
     * Function is use for get user count base on user role and display on portal admin dashboard
     */
    public function getUsersCounts(){
        $objUser = new User();
        $userscount = $objUser->getUsersCounts();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $userscount);
    }

    /**
     * @test
     *
     * This function will return all users as per given role
     */
    public function getUsersByRole(){
        $objUser = new User();
        $userlist = $objUser->getUsersByRole(2);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $userlist);
    }


}
