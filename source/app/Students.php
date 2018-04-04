<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Material;
use App\StudentActivity;
use App\Classes;
use App\User;

class Students extends Model
{
    /**
     * Function use for list of Teachers
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getStudentList()
    {
        $students = User::withTrashed()
            ->join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->leftJoin('user_schools', 'users.id', '=', 'user_schools.user_id')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at'])
            ->where('users.userrole', '=', '3');

        $authUserRole = Auth::user()->userrole;
        $usersSchools = new UsersSchools();

        $authUserSchool = 0;
        if ($authUserRole != 1) {
            // $userSchoolId = Auth::user()->userMeta->schoolId;
            $userSchoolId = $usersSchools->getUserSchools(Auth::user()->id);
        }
        if ($authUserRole == 6) // School Admin
        {
            $authUserSchool = $userSchoolId;
        }

        if ($authUserSchool > 0) {
            //$students->where('user_metas.schoolId', '=', $authUserSchool);
            $students->whereIn('user_schools.school_id', $authUserSchool);
        }
        return $students;
    }

    /**
     * Get Materials List By Student Class Id
     * @param string $classid
     * @return array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public static function getMaterialList($classid = '')
    {
        $objClassMaterials = new ClassMaterials();
        if (!empty($classid)) {
            return $objClassMaterials->getMaterialsByClassId($classid);
        } else {
            $classes = Auth::user()->classes()->first();
            if (!empty($classes->class_id)) {
                return $objClassMaterials->getMaterialsByClassId($classes->class_id);
            } else {
                return array();
            }
        }
    }

    /**
     * Will return all edesk list with teacher by class id
     * @param $classId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getStudentEdeskListByClass($classId)
    {
        $classes = new UsersClasses();
        return $classes->join('users', 'users.id', '=', 'users_classes.user_id')
            ->where('users_classes.class_id', '=', $classId)
            ->where('users.userrole', '!=', 4)
            ->orderBy('users_classes.sequence')
            ->get();
    }

}
