<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'countrycode', 'countryname'
    ];


    /**
     * Function is use for get users list from DataBase
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id');
    }

    /**
     * Building relation with User Role Model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userrole()
    {
        return $this->hasMany('App\Userrole', 'id');
    }

    /**
     * Function is use for get country list from DataBase
     * @return mixed
     */
    public function getCountryList()
    {
        $contryList = Countries::where('isactive', '=', 1)->get();
        return $contryList;
    }
}
