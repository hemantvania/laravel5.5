<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserDetails extends Model
{
    protected $fillable = [
        'user_id','occupassion', 'city', 'state','zip'
    ];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function saveUserDetails($userDetails = array())
    {

        if(!empty($userDetails))
        {
            $userDetails['user_id'] = Auth::user()->id;
            //var_dump($userDetails); die();
            return UserDetails::create($userDetails);
        }

        return "";

    }
}
