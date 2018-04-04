<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;
use App\UsersSchools;
use App\Classes;
use App\UsersClasses;
use App\School;
use App\StudentClassStatus;
use Illuminate\Support\Facades\DB;

class Teachers extends Model
{
    /**
     * Function use for list of Teachers
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTeacherList()
    {
        $teachers = User::withTrashed()
            ->join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->leftJoin('user_schools', 'users.id', '=', 'user_schools.user_id')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at'])
            ->where('users.userrole', '=', '2');

        $authUserRole = Auth::user()->userrole;
        $usersSchools = new UsersSchools();
        $authUserSchool = 0;
        if ($authUserRole != 1) {
            //$userSchoolId = Auth::user()->userMeta->schoolId;
            $userSchoolId = $usersSchools->getUserSchools(Auth::user()->id);
        }
        if ($authUserRole == 6) // School Admin
        {
            $authUserSchool = $userSchoolId;
        }
        if ($authUserSchool > 0) {
            $teachers->whereIn('user_schools.school_id', $authUserSchool);
        }
        return $teachers;
    }

    /**
     * List out the logged in Teacher Schools First Record
     * @param bool $first
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getTeacherSchools($first = true)
    {
        $authid = Auth::user()->id;
        if ($first == true) {
            $teacher_school = usersSchools::join('schools', 'school_id', '=', 'schools.id')
                ->where('user_id', '=', $authid)->first();
        } else {
            $teacher_school = usersSchools::join('schools', 'school_id', '=', 'schools.id')
                ->where('user_id', '=', $authid)->get();
        }
        return $teacher_school;
    }

    /**
     * Get Teachers Primary School
     * @return Teachers|\Illuminate\Database\Eloquent\Collection|Model|null|static[]
     */
    public function getTeachersPrimarySchool()
    {
        $authid = Auth::user()->id;
        $primarySchoolId = Auth::user()->userMeta->default_school;
        if (!empty($primarySchoolId)) {
            $teacher_school = School::withTrashed()->where('id', '=', $primarySchoolId)->get();
        } else {
            $teacher_school = self::getTeacherSchools(true);
        }
        /* $teacher_school = usersSchools::join('schools','school_id','=','schools.id')
             ->where('user_id','=',$authid)->first();*/
        return $teacher_school;
    }

    /**
     * List all classes from school id
     * @param $schoolid
     * @return object
     */
    public function getSchoolClasses($schoolid)
    {
        $classes = Classes::where('schoolid', '=', $schoolid)->get();
        return $classes;
    }

    /**
     * List all students in the current selected class
     * @param $classid
     * @return object
     */
    public function getAssignStudentsInClass($classid)
    {
        $students = UsersClasses::join('users', 'user_id', '=', 'users.id')
            ->leftJoin('manage_edesks', 'users.id', '=', 'manage_edesks.student_id')
            ->where('users_classes.class_id', '=', $classid)
            ->where('users.userrole', '=', '3')
            ->select([DB::raw("CONCAT(users.first_name,' ',users.last_name) as fullname"), 'users.id', 'users_classes.sequence', 'users_classes.class_id', 'manage_edesks.is_active as status'])->distinct()
            ->orderBy('sequence')
            ->get();
        return $students;
    }

    /**
     * List all students from logged in teacher's schools
     * @param $schoolid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSchoolUserList($schoolid)
    {
        $students = UsersSchools::join('users', 'user_id', '=', 'users.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->leftJoin('users_classes', 'users.id', '=', 'users_classes.user_id')
            ->leftJoin('classes', 'users_classes.class_id', '=', 'classes.id')
            ->where('users.userrole', '=', '3')
            ->where('school_id', '=', $schoolid)
            ->select(['users.id', 'users.first_name', 'users.last_name', 'users.email', 'user_metas.phone', 'user_metas.addressline1', 'classes.ClassName', 'users.deleted_at'])
            ->distinct();
        return $students;
    }

    /**
     * Get All Classes Assign to logged in Teacher
     * @param $schoolid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTeacherAssignClasses($schoolid)
    {
        $authid = Auth::user()->id;
        $classes = UsersClasses::join('users', 'user_id', '=', 'users.id')
            ->join('classes', 'users_classes.class_id', '=', 'classes.id')
            ->where('classes.schoolId', '=', $schoolid)
            ->where('users_classes.user_id', '=', $authid)
            ->get();
        return $classes;
    }

    /**
     * Fetching the default class for the logged in teacher
     * @param $schoolid
     * @return Model|null|static
     */
    public function getTeacherDefaultClass($schoolid)
    {
        $authid = Auth::user()->id;
        $classes = UsersClasses::join('users', 'user_id', '=', 'users.id')
            ->join('classes', 'users_classes.class_id', '=', 'classes.id')
            ->where('classes.schoolId', '=', $schoolid)
            ->where('users_classes.user_id', '=', $authid)
            ->first();
        return $classes;
    }

    /**
     * Get School Info
     * @param $schoolid
     * @return object
     */
    public function getSchoolInfo($schoolid)
    {
        return School::where('id', '=', $schoolid)->first();
    }

    /**
     * Get All Notification For Login Teacher
     * @param $schoolid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTeachersStudentNotification($schoolid)
    {
        $authid = Auth::user()->id;
        $notification = UsersClasses::from('users_classes AS uc1')
            ->join('users_classes AS uc2', function ($join) {
                $join->on('uc1.class_id', '=', 'uc2.class_id')->on('uc1.user_id', '!=', 'uc2.user_id');
            })
            ->join('users AS u', 'u.id', '=', 'uc2.user_id')
            ->join('students_class_status AS scs', function ($join) {
                $join->on('scs.class_id', '=', 'uc2.class_id')->on('scs.user_id', '=', 'uc2.user_id')->where('scs.is_completed', '=', 1);
            })
            ->join('classes AS cls', 'cls.id', '=', 'scs.class_id')
            ->where('cls.schoolId', '=', $schoolid)
            ->where('uc1.user_id', '=', $authid)
            ->where('u.userrole', '=', 3)
            ->select(['u.name', 'cls.className', 'cls.created_at'])
            ->get();
        return $notification;
    }
}
