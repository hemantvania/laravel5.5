<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersMaterialStatistics extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_material_statistics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['class_id', 'user_id', 'material_id', 'is_completed'];

    /**
     * Inserting records into tables
     * @param $classid
     * @param $userid
     * @param $materialid
     * @param $iscomplete
     * @return int
     */
    public function InsertInToStatistics($classid, $userid, $materialid, $iscomplete)
    {
        return self::insertGetId(
            [
                'class_id' => $classid,
                'user_id' => $userid,
                'material_id' => $materialid,
                'is_completed' => $iscomplete,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }

    /**
     * Get the material status for the today date
     * @param $classid
     * @param $userid
     * @param $materialid
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function GetTodayStatusOfMaterials($classid, $userid, $materialid)
    {
        return self::where('class_id', '=', $classid)
            ->where('user_id', '=', $userid)
            ->where('material_id', '=', $materialid)
            ->where('is_completed', '=', 1)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get()->count();
    }
}
