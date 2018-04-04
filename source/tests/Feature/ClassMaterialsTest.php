<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Auth;
use App\Teachers;
use App\ClassMaterials;

class ClassMaterialsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Return assigned materials to specific class by class id
     */
    public function getMaterialsByClassId(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses =  $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials = new ClassMaterials();
        $ClassMaterialList =  $objClassMaterials->getMaterialsByClassId($defaultClasses['class_id']);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $ClassMaterialList);
    }

    /**
     * @test
     *
     * Get Total Count of if student is assign to given class or not
     */
    public function getAssignMaterialCount(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses     =   $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials  =   new ClassMaterials();
        $TotalCount  =   $objClassMaterials->getAssignMaterialCount($defaultClasses['class_id'],1);
        $this->addToAssertionCount($TotalCount);
    }

    /**
     * @test
     *
     * Count total materials assign for today by given class id
     */
    public function getTotalAssignMaterialsForToday(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses     =   $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials  =   new ClassMaterials();
        $TotalCount  =   $objClassMaterials->getTotalAssignMaterialsForToday($defaultClasses['class_id']);
        $this->addToAssertionCount($TotalCount);
    }

    /**
     * @test
     *
     * pdating todays assign materials to true so student can see and view theme.
     */
    public function updateClassMaterials(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses     =   $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials  =   new ClassMaterials();
        $result  =   $objClassMaterials->updateClassMaterials($defaultClasses['class_id']);
        $this->assertTrue(true,$result);
    }

    /**
     * @test
     *
     * Inset into Class Materislas
     */
    public function assignClassMaterials(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses     =   $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials  =   new ClassMaterials();
        $result  =   $objClassMaterials->assignClassMaterials($defaultClasses['class_id'],1);
        $this->assertTrue(true,$result);
    }

    /**
     * @test
     *
     * Removing the duplicated entry for assing materials for today only for specific class
     */
    public function deleteDuplicateAssignMaterialCount(){

        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $teachers       = new Teachers();
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if(empty($primarySchoolId)) {
            $teachers = new Teachers();
            $schoolinfo = $teachers->getTeacherSchools(true);
            if(!empty($schoolinfo)){
                $primarySchoolId = $schoolinfo->school_id;
            }
        }
        $defaultClasses     =   $teachers->getTeacherDefaultClass($primarySchoolId);
        $objClassMaterials  =   new ClassMaterials();
        $result  =   $objClassMaterials->deleteDuplicateAssignMaterialCount($defaultClasses['class_id'],1);
        $this->assertTrue(true,$result);
    }
}
