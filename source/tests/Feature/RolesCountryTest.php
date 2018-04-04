<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\RolesCountry;
use App\User;
use Auth;
class RolesCountryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Function use for store user role with country in roles_countries Table
     */
    public function storeRoleCountry(){
        $countryid  = 1;
        $roleid     = 6;
        $objRolesCountry = new RolesCountry();
        $rs = $objRolesCountry->storeRoleCountry($countryid,$roleid);
        $this->assertTrue(true,$rs);
    }

    /**
     * @test
     *
     * Get Roles countries by ID
     */
    public function roleCountiresById(){
        $roleid     = 6;
        $objRolesCountry = new RolesCountry();
        $rs = $objRolesCountry->roleCountiresById($roleid);
        $this->assertInternalType("int",$rs[0]);
    }

    /**
     * @test
     *
     * Create Function for get user role list base on country selection
     */
    public function getRoleByCountry(){
        $admin = User::where('userrole','=','6')->first();
        $this->signIn($admin);
        $objRolesCountry = new RolesCountry();
        $countryid  = 1;
        $rs = $objRolesCountry->getRoleByCountry($countryid);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $rs);
    }
}
