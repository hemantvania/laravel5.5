<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Illuminate\Support\Facades\DB;

class Classes extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'className', 'schoolId', 'educationTypeId', 'standard', 'class_duration', 'class_size'
    ];

    /**
     * Build the relation with School Model
     * @return mixed
     */
    public function school()
    {
        return $this->belongsTo('App\School', 'schoolId')->withTrashed();
    }

    /**
     * Build relation with Eduction Type Model
     * @return mixed
     */
    public function education_type()
    {
        return $this->belongsTo('App\EducationType', 'educationTypeId')->withTrashed();
    }

    /**
     * Get list of all classes with schools and users
     * @return mixed
     */
    public function getClassList()
    {
        $classList = Classes::withTrashed()
            ->join('schools', 'schools.id', '=', 'classes.schoolId')
            ->join('education_types', 'education_types.id', '=', 'classes.educationTypeId')
            ->leftJoin('users_classes', 'users_classes.class_id', '=', 'classes.id')
            ->leftJoin('users', function ($join) {
                $join->on('users_classes.user_id', '=', 'users.id');
                $join->where('users.userrole', '=', '2'); // Teacher
            })
            ->select(['classes.id', 'classes.className', 'classes.standard', 'schools.schoolName', 'education_types.educationName', DB::raw('group_concat(users.name) as name'), 'users_classes.user_id', 'classes.deleted_at'])
            ->groupBy('classes.id');

        if (Auth::user()->userrole == 6) // School Admin
        {
            $usersSchools = new UsersSchools();
            $userSchoolId = $usersSchools->getUserSchools(Auth::user()->id);
            $classList->whereIn('classes.schoolId', $userSchoolId);
        }
        return $classList;
    }

    /**
     * store new class details
     * @param $classData
     * @return bool
     */
    public function addClassAdmin($classData)
    {
        if (!empty($classData)) {
            if ($class = Classes::create($classData)) {
                return $class->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is use for check record exist in DB
     * @param $id
     * @return bool
     */
    public function checkRecordExist($id)
    {
        $record = Classes::find($id);
        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for delete records from database
     * @param $id
     * @return bool
     */
    public function deleteClass($id)
    {
        $class = Classes::find($id);
        if ($class->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /** Function is create for restore deleted record
     * @param $id
     * @return bool
     */
    public function restoreRecord($id)
    {
        $class = Classes::withTrashed()->find($id);
        if ($class->restore()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get Class Info from Class ID
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getClassById($id)
    {
        $class = Classes::find($id);
        return $class;
    }

    /**
     * Function is use for update Class data
     * @param $classData
     * @param $id
     * @return bool
     */
    public function classUpdate($classData, $id)
    {
        $class = Classes::find($id);
        $class->className = $classData['className'];
        $class->schoolId = $classData['schoolId'];
        $class->educationTypeId = $classData['educationTypeId'];
        $class->standard = $classData['standard'];
        $class->class_duration = $classData['class_duration'];
        $class->class_size = $classData['class_size'];
        $update = $class->save();
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
}
