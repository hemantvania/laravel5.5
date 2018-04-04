<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassMaterials extends Model
{

    protected $table = "class_materials";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'material_id', 'is_released'
    ];

    /**
     * Return assigned materials to specific class by class id
     * @param $classId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getMaterialsByClassId($classId)
    {
        $flag = '1';
        return ClassMaterials::join('materials', 'material_id', '=', 'materials.id')
            ->where('class_materials.class_id', '=', $classId)
            // ->where('class_materials.is_released','=',true)
            ->whereNull('materials.deleted_at')
            ->whereDate('class_materials.created_at', '=', date('Y-m-d'))
            ->select(['*'])
            ->get();
    }

    /**
     * Get Total Count of if student is assign to given class or not
     * @param $classid
     * @param $materilid
     * @return int
     */
    public function getAssignMaterialCount($classid, $materilid)
    {
        return ClassMaterials::where('material_id', '=', $materilid)
            ->where('class_id', '=', $classid)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get()->count();
    }

    /**
     * Count total materials assign for today by given class id
     * @param $classid
     * @return integer
     */
    public function getTotalAssignMaterialsForToday($classid)
    {
        return ClassMaterials::join('materials', 'material_id', '=', 'materials.id')
            ->where('class_materials.class_id', '=', $classid)
            ->where('class_materials.is_released', '=', '0')
            ->whereDate('class_materials.created_at', '=', date('Y-m-d'))
            ->select(['*'])->get()->count();
    }

    /**
     * Updating todays assign materials to true so student can see and view theme.
     * @param $classid
     * @return bool|int
     */
    public function updateClassMaterials($classid)
    {
        return ClassMaterials::where('class_id', '=', $classid)
            ->whereDate('class_materials.created_at', '=', date('Y-m-d'))
            ->where('class_materials.is_released', '=', '0')
            ->update(['is_released' => true]);
    }

    /**
     * Inset into Class Materislas
     * @param $classid
     * @param $materilid
     */
    public function assignClassMaterials($classid, $materilid)
    {
        $assignMaterial = new ClassMaterials();
        $assignMaterial->class_id = $classid;
        $assignMaterial->material_id = $materilid;
        $assignMaterial->is_released = 0;
        $assignMaterial->save();
    }

    /**
     * Removing the duplicated entry for assing materials for today only for specific class
     * @param $classid
     * @param $materilid
     * @return bool|int|null
     */
    public function deleteDuplicateAssignMaterialCount($classid, $materilid)
    {
        return ClassMaterials::where('material_id', '=', $materilid)
            ->where('class_id', '=', $classid)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->delete();
    }
}
