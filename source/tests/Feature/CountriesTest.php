<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Countries;

class CountriesTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     *
     * Function is use for get country list from DataBase
     */
    public function getCountryList(){
        $objCountries = new Countries();
        $list = $objCountries->getCountryList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }
}
