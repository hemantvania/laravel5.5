<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use File;
use App\ClassMaterials;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'schools';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schoolName', 'email', 'registrationNo', 'WebUrl', 'logo', 'address1', 'address2', 'city', 'state', 'zip', 'country', 'facebook_url', 'twitter_url', 'instagram_url', 'schoolType','language'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Function is create for defining user country relation
     * @return bool
     */
    public function country()
    {
        return $this->belongsTo('App\Countries', 'country');
    }

    /**
     * Function create for return list of all school from Database
     * @param int $userId
     * @param int $role
     * @return mixed
     */
    public function getList($userId = 0, $role = 0)
    {
        $authUserRole = !empty($role) ? $role : Auth::user()->userrole;
        $authID = !empty($userId) ? $userId : Auth::user()->id;
        if ($authUserRole == 6) {
            $usersSchools = new UsersSchools();
            $userSchoolId = $usersSchools->getUserSchools($authID);
            return self::whereIn('id', $userSchoolId)->withTrashed()->get();
        }
        return self::withTrashed()->get();
    }

    /**
     * Function is use for check record exist in DB
     * @param $id
     * @return bool
     */
    public function checkRecordExist($id)
    {
        $record = School::find($id);
        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for get school records from id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getSchoolById($id)
    {
        $school = School::find($id);
        return $school;
    }

    /**
     * Function is use for store school data in school table
     * @param $schoolData
     * @return bool
     */
    public function storeSchool($schoolData)
    {
        $school = new School();
        $school->schoolName = $schoolData['schoolName'];
        $school->email = $schoolData['email'];
        $school->registrationNo = $schoolData['registrationNo'];
        $school->WebUrl = $schoolData['WebUrl'];
        $school->address1 = $schoolData['address1'];
        $school->address2 = $schoolData['address2'];
        $school->city = $schoolData['city'];
        $school->state = $schoolData['state'];
        $school->zip = $schoolData['zip'];
        $school->country = $schoolData['country'];
        $school->facebook_url = !empty($schoolData['facebook_url']) ? $schoolData['facebook_url'] : "";
        $school->twitter_url = !empty($schoolData['twitter_url']) ? $schoolData['twitter_url'] : "";
        $school->instagram_url = !empty($schoolData['instagram_url']) ? $schoolData['instagram_url'] : "";
        $school->schoolType = 1;
        $school->language = $schoolData['language'];

        if (!empty($schoolData['logo'])) {
            $school->logo = $schoolData['logo']->store("school-logo");
            $img = Image::make(storage_path('app/' . $school->logo));
            $img->resize(null, 55, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }

        if ($school->save()) {
            return $school->id;
        } else {
            return false;
        }
    }

    /**
     * Function is use for update schools data
     * @param $schoolData
     * @param $id
     * @return bool
     */
    public function schoolUpdate($schoolData, $id)
    {

        $school = self::find($id);
        $school->schoolName = $schoolData['schoolName'];
        $school->email = $schoolData['email'];
        $school->registrationNo = $schoolData['registrationNo'];
        $school->WebUrl = $schoolData['WebUrl'];
        $school->address1 = $schoolData['address1'];
        $school->address2 = $schoolData['address2'];
        $school->city = $schoolData['city'];
        $school->state = $schoolData['state'];
        $school->zip = $schoolData['zip'];
        $school->country = $schoolData['country'];
        $school->facebook_url = $schoolData['facebook_url'] ? $schoolData['facebook_url'] : "";
        $school->twitter_url = $schoolData['twitter_url'] ? $schoolData['twitter_url'] : "";
        $school->instagram_url = $schoolData['instagram_url'] ? $schoolData['instagram_url'] : "";
        $school->schoolType = 1;
        $school->language = $schoolData['language'];

        if (!empty($schoolData['remove_logo'])) {
            File::delete(storage_path('app/' . $school->logo));
            $school->logo = "";
        }
        if (!empty($schoolData['logo'])) {
            /* REMOVE OLD FILE */
            File::delete(storage_path('app/' . $school->logo));
            $school->logo = $schoolData['logo']->store("school-logo");
            $img = Image::make(storage_path('app/' . $school->logo));
            // resize image to fixed size
            $isWidthGrater = $img->width() > $img->height() ? 1 : ($img->width() < $img->height() ? 2 : 0);
            if ($isWidthGrater == 1) {
                // resize the image to a width of 110 and constrain aspect ratio (auto height)
                $img->resize(110, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif ($isWidthGrater == 2) {
                // resize the image to a height of 55 and constrain aspect ratio (auto width)
                $img->resize(null, 55, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img->resize(110, 55);
            }
            $img->save();
        }

        /*$isDiscrictAssigned = self::getSchoolDistrictByShoolId($school->id);

         if(empty($isDiscrictAssigned->id))
           {
               $userSchool             = new UsersSchools();
               $userSchool->user_id    = $schoolData['school_district'];
               $userSchool->school_id  = $school->id;
               $userSchool->save();
           }
           else
           {
               UsersSchools::where('id','=',$isDiscrictAssigned->id)->update(['user_id'=>$schoolData['school_district']]);
           }*/

        if ($school->update()) {
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
    public function schoolDelete($id)
    {
        $school = School::find($id);
        if ($school->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is create for restore deleted record
     * @param $id
     * @return bool
     */
    public function restoreRecord($id)
    {
        $school = School::withTrashed()->find($id);
        if ($school->restore()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get School District
     * @param $schoolId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSchoolDistrictByShoolId($schoolId)
    {
        return UsersSchools::select('user_schools.*', 'users.id as userid')->where('user_schools.school_id', '=', $schoolId)
            ->join('users', function ($join) {
                $join->on('user_schools.user_id', '=', 'users.id')->where('users.userrole', '=', 4);
            })
            ->first();
    }

    /**
     * Fetch the Schools Assign to school district
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSchoolListBySchoolDistrict()
    {
        return UsersSchools::join('schools', 'user_schools.school_id', '=', 'schools.id')
            ->where('user_id', Auth::user()->id)
            ->select('schools.schoolName', 'schools.email', 'schools.registrationNo', 'schools.WebUrl', 'schools.address1')
            ->distinct('schools.id')
            ->get();
    }

    /**
     * Fetch all the teachers which is assign to school for school district
     * @return $this
     */
    public function getTeachersListBySchools()
    {
        $authID = Auth::user()->id;
        return User::join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->join('user_schools', 'users.id', '=', 'user_schools.user_id')
            ->join('schools', 'user_schools.school_id', '=', 'schools.id')
            ->leftJoin('user_schools as us2', function ($join) {
                $join->on('user_schools.school_id', '=', 'us2.school_id')->on('user_schools.user_id', '!=', 'us2.user_id');
            })
            ->where('us2.user_id', '=', $authID)
            ->where('users.userrole', '=', '2')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at', 'schools.schoolName']);
    }

    /**
     * Fetch the students which assign to schools for school district
     * @return $this
     */
    public function getStudentsListBySchools()
    {
        $authID = Auth::user()->id;
        return User::join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->join('user_schools', 'users.id', '=', 'user_schools.user_id')
            ->join('schools', 'user_schools.school_id', '=', 'schools.id')
            ->leftJoin('user_schools as us2', function ($join) {
                $join->on('user_schools.school_id', '=', 'us2.school_id')->on('user_schools.user_id', '!=', 'us2.user_id');
            })
            ->where('us2.user_id', '=', $authID)
            ->where('users.userrole', '=', '3')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at', 'schools.schoolName']);
    }

    /**
     * Total Share Materials School District having schools and its classes
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function shareMaterialStatisticBySchoolDistrict()
    {
        $authID = Auth::user()->id;
        $shareStatisticCount = ClassMaterials::join('materials as ma', 'material_id', '=', 'ma.id')
            ->join('classes', 'class_materials.class_id', '=', 'classes.id')
            ->join('schools', 'classes.schoolId', '=', 'schools.id')
            ->join('user_schools', 'schools.id', '=', 'user_schools.school_id')
            ->where('user_schools.user_id', $authID)
            ->select('materialType', DB::raw('count(materialType) as totalrecords'))
            ->groupBy('materialType')
            ->get();
        return $shareStatisticCount;
    }

    /**
     * Function is case for get view material statistics count
     * @return mixed
     */
    public function viewMaterialStatisticBySchoolDistrict()
    {
        $authID = Auth::user()->id;
        $viewStatisticCount = UsersMaterialStatistics::join('materials as ma', 'material_id', '=', 'ma.id')
            ->join('classes', 'users_material_statistics.class_id', '=', 'classes.id')
            ->join('schools', 'classes.schoolId', '=', 'schools.id')
            ->join('user_schools', 'schools.id', '=', 'user_schools.school_id')
            ->where('user_schools.user_id', $authID)
            ->select('materialType', DB::raw('count(materialType) as totalrecords'))
            ->groupBy('materialType')
            ->get();
        return $viewStatisticCount;
    }

    /**
     * Fetch the Shared Materials Class wise in School District
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getSharedMaterialsListBySchoolsClasses()
    {
        $authID = Auth::user()->id;
        $shareStatisticCount = ClassMaterials::join('materials as ma', 'material_id', '=', 'ma.id')
            ->join('classes', 'class_materials.class_id', '=', 'classes.id')
            ->join('schools', 'classes.schoolId', '=', 'schools.id')
            ->join('user_schools', 'schools.id', '=', 'user_schools.school_id')
            // ->join('materials as video','materilas_id','=','video.id')
            ->leftJoin('materials as video', function ($join) {
                $join->on('class_materials.material_id', '=', 'video.id')->where('video.materialType', '=', 'Video');
            })
            ->leftJoin('materials as audio', function ($join) {
                $join->on('class_materials.material_id', '=', 'audio.id')->where('audio.materialType', '=', 'Audio');
            })
            ->leftJoin('materials as links', function ($join) {
                $join->on('class_materials.material_id', '=', 'links.id')->where('links.materialType', '=', 'Link');
            })
            ->leftJoin('materials as pdf', function ($join) {
                $join->on('class_materials.material_id', '=', 'pdf.id')->where('pdf.materialType', '=', 'Pdf');
            })
            ->where('user_schools.user_id', $authID)
            ->select('schools.schoolName', 'classes.className', DB::raw('count(video.materialType) as totalvideo'), DB::raw('count(audio.materialType) as totalaudio'), DB::raw('count(links.materialType) as totallinks'), DB::raw('count(pdf.materialType) as totalpdf'))
            ->groupBy('classes.id')
            ->get();
        return $shareStatisticCount;
    }
}
