<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\EducationType;

class EducationTypeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Get all eduction types listing
     */
    public function getTypes(){
        $objEducationType = new EducationType();
        $list = $objEducationType->getTypes();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }
}
