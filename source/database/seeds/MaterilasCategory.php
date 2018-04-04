<?php

use Illuminate\Database\Seeder;
use App\MaterialCategory;
class MaterilasCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $materilasCategories = array(
            array(
                'categoryName'  =>'Computer Science',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Internet',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Chemistry',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Social',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Sport',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Politics',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Mathametics',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Science',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Managment',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryName'  =>'Computer Programming',
                'parentCatId'   =>0,
                'isActive'      =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            )


        );
        MaterialCategory::insert($materilasCategories);
    }
}
