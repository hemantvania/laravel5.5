<?php

use Illuminate\Database\Seeder;
use App\Countries;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
			array(
			    'countrycode' => 'FI',
                'countryname' => 'Finland',
                'isactive'=>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'countrycode' => 'SE',
                'countryname' => 'Sweden',
                'isactive'=>0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        Countries::insert($countries);
    }
}
