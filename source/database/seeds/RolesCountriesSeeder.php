<?php

use Illuminate\Database\Seeder;
use App\RolesCountry;
class RolesCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rolesCountryarr = array(
            array(
                'roleId' => 1,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'roleId' => 2,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'roleId' => 3,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'roleId' => 4,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'roleId' => 5,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'roleId' => 6,
                'countires' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        RolesCountry::insert($rolesCountryarr);
    }
}
