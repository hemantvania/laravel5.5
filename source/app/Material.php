<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use phpDocumentor\Reflection\Types\Null_;
use App\UsersMaterialStatistics;
use App\ClassMaterials;

class Material extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categoryId', 'materialName', 'description', 'link', 'materialType', 'uploadBy', 'materialIcon','langauge'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Function use for list of all getMaterialList
     * @return $this
     */
    public function getMaterialList()
    {
        $authid = Auth::user()->id;
        $materials = $this->join('users', 'uploadBy', '=', 'users.id')
            ->whereIn('uploadBy', [$authid, DB::raw("(SELECT id FROM users WHERE userrole=5)")])
            ->select([DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"), 'users.id', 'materials.id', 'materials.materialName', 'materials.link', 'materials.description', 'users.first_name', 'users.last_name', 'materials.materialType', 'materials.isDownloadable', 'materials.created_at','materials.uploadBy']);
        return $materials;
    }

    /**
     * List Out Distinct Material Type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllType()
    {
        $types = $this->select("materialType")->distinct()->get();
        return $types;
    }

    /**
     * Get All Owner of the Materials
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllOwner()
    {
        $owners = $this->join('users', 'uploadBy', '=', 'users.id')
            ->select('materials.uploadBy as ownerid', DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"))->distinct()->get();
        return $owners;
    }

    /**
     * Function use for list of all getMaterialList
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllMaterialList()
    {
        $materials = Material::join('users', 'uploadBy', '=', 'users.id')
            ->select(['materials.id', 'materials.materialName', 'materials.description', 'users.first_name', 'users.last_name', 'materials.materialType', 'materials.link', 'materials.created_at', 'materials.deleted_at']);
        return $materials;
    }

    /**
     * Function is use for store material in database
     * @param array $materialData
     * @return bool
     */
    public static function storeMaterial($materialData)
    {
        $storeIcon = '';
        if (!empty($materialData['uploadcontent'])) {
            $storeContent = $materialData['uploadcontent']->store("contents");
            $link = $storeContent;
            $isDownloadable = 1;
        } else {
            $link = $materialData['link'];
            $isDownloadable = 2;
        }
        if (!empty($materialData['materialIcon'])) {
            $storeIcon = $materialData['materialIcon']->store("contentsicons");
        }
        $material = new Material();
        $material->materialName = $materialData['materialName'];
        $material->categoryId = $materialData['categoryId'];
        $material->description = $materialData['description'];
        $material->link = $link;
        $material->materialType = $materialData['materialType'];
        $material->uploadBy = Auth::user()->id;
        $material->materialIcon = $storeIcon;
        $material->isDownloadable = $isDownloadable;
        $material->language = $materialData['language'];
        if ($material->save()) {
            return $material->id;
        } else {
            return false;
        }
    }

    /**
     * Function is use for get material detail by id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function geMaterialById($id)
    {
        return Material::find($id);
    }

    /**
     * Function use for update material detail
     * @param array $materialData `
     * @param $id
     * @return bool
     */
    public static function updateMaterialDetail($materialData, $id)
    {
        $material = Material::find($id);
        if (!empty($materialData['uploadcontent'])) {
            $storeContent = $materialData['uploadcontent']->store("contents");
            $link = $storeContent;
            $isDownloadable = 1;
        } else {
            $link = $materialData['link'];
            $isDownloadable = 2;
        }

        if (!empty($materialData['materialIcon'])) {
            $storeIcon = $materialData['materialIcon']->store("contentsicons");
        }

        $material->materialName = $materialData['materialName'];
        $material->categoryId = $materialData['categoryId'];
        $material->description = $materialData['description'];

        if (!empty($link)) {
            $material->link = $link;
            $material->isDownloadable = $isDownloadable;
        }
        $material->materialType = $materialData['materialType'];

        $material->uploadBy = Auth::user()->id;
        $material->language = $materialData['language'];
        if (!empty($materialData['remove_materialIcon'])) {
            $material->materialIcon = "";
        } else {
            if (!empty($storeIcon)) {
                $material->materialIcon = $storeIcon;
            }
        }

        if ($material->update()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function use for delete material
     * @param $id
     * @return bool
     */
    public static function destroyMaterialById($id)
    {
        if (!empty($id)) {
            $material = Material::find($id);
            if ($material->delete()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is create for restore deleted record
     * @param $id
     * @return bool
     */
    public static function restoreRecord($id)
    {
        if (!empty($id)) {
            $material = Material::withTrashed()->find($id);
            if ($material->restore()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is check is material downloadable return true is downloadable else false
     * @param $id
     * @return bool
     */
    public function checkIsMaterialDownloadable($id)
    {
        $material = Material::withTrashed()->find($id);
        if (!empty($material->isDownloadable) && $material->isDownloadable == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is check is material downloadable and return array of all files
     * @param $contents
     * @return array
     */
    public function downloadProcess($contents)
    {
        $filePaths = [];
        if (!empty($contents)) {
            foreach ($contents as $content) {
                $isValid = $this->checkIsMaterialDownloadable($content);
                if ($isValid) {
                    $material = Material::withTrashed()->find($content);
                    $filePaths[] = $material->link;
                }
            }
        }
        return $filePaths;
    }

    /**
     * Create for change material status
     * @param $newStatus
     * @param $id
     * @return bool
     */
    public function changeMaterialFormat($newStatus, $id)
    {
        $material = Material::withTrashed()->find($id);
        $material->isDownloadable = $newStatus;
        if ($material->update()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is cuse for get view material statistics count
     * @return mixed
     */
    public function viewMaterialStatistic()
    {
        $viewStatisticCount = UsersMaterialStatistics::join('materials as ma', 'material_id', '=', 'ma.id')
            ->select('materialType', DB::raw('count(materialType) as totalrecords'))
            ->groupBy('materialType')
            ->get();
        return $viewStatisticCount;
    }

    /**
     * Function is cuse for get share material statistics count
     * @return mixed
     */
    public function shareMaterialStatistic()
    {
        $shareStatisticCount = ClassMaterials::join('materials as ma', 'material_id', '=', 'ma.id')
            ->select('materialType', DB::raw('count(materialType) as totalrecords'))
            ->groupBy('materialType')
            ->get();
        return $shareStatisticCount;
    }
}