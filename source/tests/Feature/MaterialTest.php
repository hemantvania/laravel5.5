<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use Auth;
use App\Material;

class MaterialTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * @test
     */
    public function getMaterialList(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $objMaterial = new Material();
        $materials   = $objMaterial->getMaterialList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $materials);
    }

    /**
     * @test
     */
    public function getAllType(){
        $objMaterial = new Material();
        $materialsType   = $objMaterial->getAllType();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $materialsType);
    }

    /**
     * @test
     */
    public function getAllOwner(){
        $objMaterial = new Material();
        $owners   = $objMaterial->getAllOwner();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $owners);
    }

    /**
     * @test
     */
    public function getAllMaterialList(){
        $objMaterial = new Material();
        $list   = $objMaterial->getAllMaterialList();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $list);
    }

    /**
     * @test
     */
    public function storeMaterial(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $this->assertTrue(true,$storedata);
    }

    /**
     * @test
     */
    public function geMaterialById(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $this->assertInternalType("int", $storedata);
    }

    /**
     * @test
     */
    public function updateMaterialDetail(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $updatedata = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM the AP',
            'categoryId'    => 1,
            'description'   => 'this is testing deskdddddddd',
            'materialType'  => 1,
        );
        $update   = $objMaterial->updateMaterialDetail($updatedata,$storedata);
        $this->assertTrue(true,$update);

    }

    /**
     * @test
     */
    public function destroyMaterialById(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $destroy = $objMaterial->destroyMaterialById($storedata);
        $this->assertTrue(true,$destroy);
    }

    /**
     * @test
     */
    public function restoreRecord(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $destroy = $objMaterial->destroyMaterialById($storedata);
        $restore = $objMaterial->restoreRecord($storedata);
        $this->assertTrue(true,$restore);
    }

    /**
     * @test
     */
    public function checkIsMaterialDownloadable(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $isdownloadble = $objMaterial->checkIsMaterialDownloadable($storedata);
        $this->assertTrue(true,$isdownloadble);
    }


    /**
     * @test
     */
    public function changeMaterialFormat(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $authid =  Auth::user()->id;
        $data = array(
            'link'          => 'http://www.google.com',
            'materialName'  => 'Testing JM',
            'categoryId'    => 1,
            'description'   => 'this is testing desk',
            'materialType'  => 1,
        );
        $objMaterial = new Material();
        $storedata   = $objMaterial->storeMaterial($data);
        $isdownloadble = $objMaterial->changeMaterialFormat(1,$storedata);
        $this->assertTrue(true,$isdownloadble);
    }

    /**
     * @test
     */
    public function viewMaterialStatistic(){
        $objMaterial = new Material();
        $list   = $objMaterial->viewMaterialStatistic();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }

    /**
     * @test
     */
    public function shareMaterialStatistic(){
        $objMaterial = new Material();
        $list   = $objMaterial->shareMaterialStatistic();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }
}
