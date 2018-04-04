<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Userrole;
use App\User;
use Auth;
class UserRoleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Function get User Role Detail By Id
     */
    public function getUserroleById(){
        $userrole = new Userrole();
        $result = $userrole->getUserroleById(1);
        $expectedResult = true;
        $this->assertArrayHasKey('rolename',$result);
    }

    /**
     * @test
     *
     * Function is use for get all roles list from DataBase
     */
    public function getList(){
        $admin = User::where('userrole','=','6')->first();
        $this->signIn($admin);
        $objUserrole = new Userrole();
        $list = $objUserrole->getList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }

    /**
     * @test
     *
     * Function is use for check record exist
     */
    public function checkRecordExist(){
        $rolid = 6;
        $objUserrole = new Userrole();
        $list = $objUserrole->checkRecordExist($rolid);
        $this->assertTrue(true,$list);
    }

    /**
     * @test
     *
     * Function is use for store role in DataBase
     */
    public function storeRole(){

        $rolename = 'Testing';
        $isactive = 1;
        $countires = array(1);
        $objUserRole = new Userrole();
        $Roles = $objUserRole->storeRole($rolename,$isactive,$countires);
        $this->assertTrue(true,$Roles);
    }

    /**
     * @test
     *
     * Function is use for update role in DataBase
     */
    public function updateRole(){
        $rolename = 'Testing';
        $isactive = 1;
        $countires = array(1);
        $objUserRole = new Userrole();
        $Roles = $objUserRole->updateRole($rolename,$isactive,$countires,1);
        $this->assertTrue(true,$Roles);
    }
}
