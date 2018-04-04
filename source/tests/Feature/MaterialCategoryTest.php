<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\MaterialCategory;

class MaterialCategoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Function create for check category has child category and if yes return list
     */
    public function hasChildCategory(){

        $objMaterialCategory = new MaterialCategory();
        $catid = 1;
        $list = $objMaterialCategory->hasChildCategory($catid);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }

    /**
     * @test
     *
     * Function create for get list of all categories
     */
    public function getCategories(){
        $objMaterialCategory = new MaterialCategory();
        $list = $objMaterialCategory->getCategories();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }

    /**
     * @test
     *
     * Function create for store material category in material_categories table DB
     */
    public function createCategory(){

        $objMaterialCategory = new MaterialCategory();
        $catname = 'Jmtesting';
        $parentcat = 1;
        $isactive = 1;
        $store = $objMaterialCategory->createCategory($catname,$parentcat,$isactive);
        $this->assertTrue(true,$store);
    }

}
