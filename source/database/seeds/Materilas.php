<?php

use Illuminate\Database\Seeder;
use App\Material;
class Materilas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $materials = array(
            array(
                'categoryId'    =>1,
                'materialName'  =>'Materilas Video 1',
                'description'   =>'Web Publishing',
                'link'          =>'http://www.google.com',
                'materialType'  =>'Video',
                'uploadBy'      =>2,
                'materialIcon'  =>'',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryId'    =>1,
                'materialName'  =>'PDF file for download',
                'description'   =>'Web Publishing',
                'link'          =>'http://www.google.com',
                'materialType'  =>'Pdf',
                'uploadBy'      =>2,
                'materialIcon'  =>'',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryId'    =>1,
                'materialName'  =>'link to open in new tab',
                'description'   =>'Web Publishing',
                'link'          =>'http://www.google.com',
                'materialType'  =>'Link',
                'uploadBy'      =>2,
                'materialIcon'  =>'',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'categoryId'    =>1,
                'materialName'  =>'Audio file',
                'description'   =>'Web Publishing',
                'link'          =>'https://www.youtube.com/watch?v=avZTQgLs064',
                'materialType'  =>'Audio',
                'uploadBy'      =>2,
                'materialIcon'  =>'',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        Material::insert($materials);
    }
}
