<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\School;

class UsersSchools extends Model
{
    protected $table = "user_schools";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'school_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Relation build with school model
     * @return mixed
     */
    public function school()
    {
        return $this->belongsTo('App\School')->withTrashed();
    }

    /**
     * Function is use for get user schools details
     * @param $id
     * @param bool $asArray
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserSchools($id, $asArray = true)
    {
        if ($asArray) {
            return self::select('school_id')->where('user_id', $id)->pluck('school_id')->toArray();
        }
        return self::select('school_id')->where('user_id', $id)->distinct('school_id','ASC')->get();
    }

    /**
     * Update Users Schools
     * @param array $schoolIds
     * @param null $id
     * @return bool
     */
    public function updateUserSchools($schoolIds = array(), $id = NULL)
    {
        if (!empty($schoolIds)) {
            $schools = $schoolIds;
            $userRole = "";
            if (!empty($id)) {
                $userRole = User::find($id)->userrole;
                self::where('user_id', '=', $id)->delete();
            }
            $schoolObj = new School();
            if (!empty($schools)) {
                foreach ($schools as $school) {
                    // if it is SchoolDiscritct
                    if ($userRole == 4) {
                        /* CHECK IF SCHOOL ALREADY HAVE DISTRICT */
                        $hasDistrict = $schoolObj->getSchoolDistrictByShoolId($school);
                        if (!empty($hasDistrict->id)) {
                            self::where('id', '=', $hasDistrict->id)->update(['user_id' => $id]);
                        }
                    }
                    $this->storeUsersSchool($id, $school);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Insert records into Users Schools
     * @param $userid
     * @param $schoolid
     */
    public function storeUsersSchool($userid, $schoolid)
    {
        $userSchool = new UsersSchools();
        $userSchool->user_id = $userid;
        $userSchool->school_id = $schoolid;
        $userSchool->save();
    }

    /**
     * Delete the records of user
     * @param $userid
     * @return bool|null
     */
    public function deleteUsersSchool($userid){
        return self::where('user_id', '=', $userid)->delete();
    }
}
