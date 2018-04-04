<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class RolesCountry extends Model
{
    protected $table = 'roles_countries';

    protected $fillable = [
        'roleId', 'countires'
    ];

    /**
     * Building relation with Userrole Model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userroles()
    {
        return $this->belongsTo('App\Userrole', 'id');
    }

    /**
     * Building relation with Countires Model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countries()
    {
        return $this->belongsTo('App\Countries', 'id');
    }

    /**
     * Function use for store user role with country in roles_countries Table
     * @param $countires
     * @param $id
     * @return bool
     */
    public function storeRoleCountry($countires, $id)
    {
        $roleCountry = new RolesCountry();
        $roleCountry->roleId = $id;
        $roleCountry->countires = $countires;
        $roleCountry->save();
    }

    /**
     * Get Roles countries by ID
     * @param $id
     * @return array
     */
    public function roleCountiresById($id)
    {
        $countiresArray = array();
        $countiresList = RolesCountry::where('roleId', $id)->get(['countires']);
        if (!empty($countiresList)) {
            foreach ($countiresList as $country) {
                $countiresArray[] = $country->countires;
            }
        }
        return $countiresArray;
    }

    /**
     * Delete Roles Countries By ID
     * @param $id
     * @return bool
     */
    public function deleteCountriesByRoleId($id)
    {
        $deleteRecord = RolesCountry::where('roleId', '=', $id);
        if ($deleteRecord->delete()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Create Function for get user role list base on country selection
     * @param $country
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getRoleByCountry($country)
    {
        $authRole = Auth::user()->userrole;
        if ($authRole == 5) {
            $roles = [2, 4, 6];
            $list = RolesCountry::leftjoin('userroles', 'roles_countries.roleId', '=', 'userroles.id')->whereIn('userroles.id', $roles)->where('roles_countries.countires', $country)->get();
        } else {
            $list = RolesCountry::leftjoin('userroles', 'roles_countries.roleId', '=', 'userroles.id')->where('roles_countries.countires', $country)->get();
        }
        return $list;
    }
}
