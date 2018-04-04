<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Input;
use App\Countries;
use App\RolesCountry;

class Userrole extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'userroles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rolename'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Function get User Role Detail By Id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getUserroleById($id)
    {
        $list = Userrole::find($id);
        return $list;
    }

    /**
     * Function is use for get all roles list from DataBase
     * @return mixed
     */
    public static function getList()
    {
        $userroles = Userrole::withTrashed()->get();
        $authRole = Auth::user()->userrole;
        if ($authRole == 5) {
            $roles = [2, 4];
            $userroles = Userrole::whereIn('id', $roles)->withTrashed()->get();
        } else {
            $userroles = Userrole::withTrashed()->get();
        }
        return $userroles;
    }

    /**
     * Function is use for check record exist
     * @param $id
     * @return bool
     */
    public function checkRecordExist($id)
    {
        $record = Userrole::find($id);
        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for store role in DataBase
     * @param $rolename
     * @param $isactive
     * @param $countires
     * @return bool
     */
    public function storeRole($rolename, $isactive, $countires)
    {
        $userrole = new Userrole();
        $userrole->rolename = $rolename;
        $userrole->isactive = $isactive;
        $userrole->save();
        if ($userrole) {
            $roleId = $userrole->id;
            $storeCountires = new RolesCountry();
            if (!empty($countires)) {
                foreach ($countires as $country) {
                    $storeCountires->storeRoleCountry($country, $roleId);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for update role in DataBase
     * @param $rolename
     * @param $isactive
     * @param $countires
     * @param $id
     * @return bool
     */
    public function updateRole($rolename, $isactive, $countires, $id)
    {
        $userrole = Userrole::find($id);
        $userrole->rolename = $rolename;
        $userrole->isactive = $isactive;
        $countires = $countires;
        if ($userrole->update()) {
            $storeCountires = new RolesCountry();
            $storeCountires->deleteCountriesByRoleId($id);
            if (!empty($countires)) {
                foreach ($countires as $country) {
                    $storeCountires->storeRoleCountry($country, $id);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function is use for delete role from DataBase
     * @param $id
     * @return bool
     */
    public function deleteUserrole($id)
    {
        $userrole = Userrole::find($id);
        if ($userrole->delete()) {
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
        $userrole = Userrole::withTrashed()->find($id);
        if ($userrole->restore()) {
            return true;
        } else {
            return false;
        }
    }
}
