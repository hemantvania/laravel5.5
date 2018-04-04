<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UserMeta;
use Input;
use Hash;
use App\Userrole;
use App\UsersSchools;
use DB;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'email', 'password', 'userrole'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Building relatino with User Meta Model
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userMeta()
    {
        return $this->hasOne('App\UserMeta', 'userId');
    }

    /**
     * Building relation with Users Classes Model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes()
    {
        return $this->hasMany('App\UsersClasses', 'user_id', 'id');
    }

    /**
     * Building relation with User Role Model
     * @return bool
     */
    public function userRoles()
    {
        return $this->belongsTo('App\Userrole', 'userrole');
    }

    /**
     * Building relation with School Model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schools()
    {
        return $this->hasMany('App\School');
    }

    /**
     * Attempt Login for user
     * @param $data
     * @return bool
     */
    public static function generalLogin($data)
    {
        if (Auth::attempt($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for check record exist
     * @param $id
     * @return bool
     */
    public function checkUserExist($id)
    {
        $record = User::find($id);
        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function use for list of all users
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getUserList()
    {
        $users = User::withTrashed()
            ->where('users.userrole', '!=', '5')
            ->where('users.userrole', '!=', '3')
            ->join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at']);
        return $users;
    }

    /**
     * Returns list of School Districts user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSchoolDistrict()
    {
        return User::where('userrole', '4')->get();
    }

    /**
     * Function get User Detail By Id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getUserById($id)
    {
        $list = User::find($id);
        return $list;
    }

    /**
     * Function is use for store / create user for super user only
     * @param $userData
     * @return bool|mixed
     */
    public function createUserAdmin($userData)
    {
        if (!empty($userData)) {
            $userName = strip_tags($userData['name']);
            $lastName = strip_tags($userData['last_name']);
            $data['first_name'] = $userName;
            $data['name'] = $userName . ' ' . $lastName;
            $data['last_name'] = $lastName;
            $data['userrole'] = $userData['userrole'];
            $data['email'] = $userData['email'];
            $data['password'] = Hash::make($userData['password']);
            $user = User::create($data);

            $userId = $user->id;
            $userMeta['userId'] = $userId;
            $userMeta['phone'] = $userData['phone'];
            $userMeta['addressline1'] = strip_tags($userData['addressline1']);
            $userMeta['addressline2'] = strip_tags($userData['addressline2']);
            $userMeta['city'] = strip_tags($userData['city']);
            $userMeta['zip'] = $userData['zip'];
            $userMeta['country'] = $userData['country'];
            $userMeta['ssn'] = strip_tags($userData['ssn']);
            $userMeta['gender'] = $userData['gender'];
            $userMeta['default_school'] = $userData['default_school'];
            $userMeta['profileimage'] = !empty($userData['profileimage']) ? $userData['profileimage'] : "";
            $userMeta['language'] = !empty($userData['default_language']) ? $userData['default_language'] : "";
            //user_preference
            //$userMeta['user_preference'] = !empty($userData['user_preference']) ? $userData['user_preference'] : "";
            $userMeta['user_preference'] = !empty($userData['default_language']) ? $userData['default_language'] : "";
            $schoolMeta = $userData["schoolId"];
            if (!empty($userData['enable_share_screen'])) {
                $userMeta['enable_share_screen'] = $userData['enable_share_screen'];
            }
            $userSchools = new usersSchools();
            $userSchools->updateUserSchools($schoolMeta, $userId);
            // only portal admin has option to set default school for teachers
            $userMeta['default_school'] = $userData['default_school'] !== null ? $userData['default_school'] : $userMeta['schoolId'];
            if ($userData['userrole'] != 2 && $userData['default_school'] != $userData['schoolId']) {
                $userData['default_school'] = $userData['schoolId'];
            }
            if (UserMeta::create($userMeta)) {
                return $userId;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is use for update user in users table
     * @param $userData
     * @param $id
     * @return bool
     */
    public function updateUser($userData, $id)
    {

        if (!empty($userData)) {
            $user = User::find($id);
            $userName = strip_tags($userData['name']);
            $lastName = strip_tags($userData['last_name']);
            $user->name = $userName . ' ' . $lastName;
            $user->first_name = $userName;
            $user->last_name = $lastName;
            $user->email = $userData['email'];
            $user->userrole = $userData['userrole'];
            if (!empty($userData['password'])) {
                $user->password = Hash::make($userData['password']);
            }
            if ($user->update()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is use for delete user from DataBase
     * @param $id
     * @return bool
     */
    public function deleteUser($id)
    {
        if (!empty($id)) {
            $user = User::find($id);
            if ($user->delete()) {
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
    public function restoreRecord($id)
    {
        if (!empty($id)) {
            $user = User::withTrashed()->find($id);
            if ($user->restore()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function is use for get user count base on user role and display on portal admin dashboard
     * @return mixed
     */
    public function getUsersCounts()
    {
        $usersCount = User::select('users.userrole', DB::raw('count(users.userrole) as totalrecords'))
            //->join('user_metas', 'users.id', 'user_metas.userId')
            ->groupBy('users.userrole')
            ->get();
        return $usersCount;
    }

    /**
     * Function is use for get user base on assign school to school district and display on school district dashboard
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSchoolDistrictUsers()
    {
        $authID = Auth::user()->id;
        $userSchools = UsersSchools::from('user_schools as us1')
            ->join('user_schools as us2', function ($join) {
                $join->on('us1.school_id', '=', 'us2.school_id')->on('us1.user_id', '!=', 'us2.user_id');
            })
            ->join('users as u', 'us2.user_id', '=', 'u.id')
            ->where('us1.user_id', $authID)
            ->join('schools as s', 's.id', '=', 'us1.school_id')
            ->select('s.schoolName', 's.id', 'us1.user_id', 'u.userrole', DB::raw('count(u.userrole) as totalrecords'))
            ->groupBy('u.userrole')
            ->get();
        return $userSchools;
    }

    /**
     * Send Password Reset Notification
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomResetPasswordToken($token));
    }

    /**
     * This function will return all users as per given role
     * @param $roleId
     * @return mixed
     */
    public function getUsersByRole($roleId)
    {
        $users = User::where('users.userrole', '=', $roleId)
            ->join('userroles', 'users.userrole', '=', 'userroles.id')
            ->join('user_metas', 'users.id', '=', 'user_metas.userId')
            ->select(['users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'userroles.rolename', 'user_metas.phone', 'user_metas.addressline1', 'users.deleted_at']);
        return $users;
    }

    /**
     * Creating new user
     * @param $userData
     * @return int
     */
    public function createUser($userData)
    {
        $userName = strip_tags($userData['name']);
        $lastName = strip_tags($userData['last_name']);
        return $id = self::insertGetId(
            [   'first_name'    => $userName,
                'name'          => $userName . ' ' . $lastName,
                'last_name'     => $lastName,
                'userrole'      => $userData['userrole'],
                'email'         => $userData['email'],
                'password'      => Hash::make($userData['password']),
                'created_at'    => new \DateTime(),
                'updated_at'    => new \DateTime()
            ]
        );

    }
}
