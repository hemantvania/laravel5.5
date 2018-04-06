<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','mobile_no'
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    public function userDetails()
    {
        return $this->hasOne('App\UserDetails');
    }

    public function Role()
    {
        return $this->belongsTo('App\UserRoles','role');
    }

    public static function getUsers($limit = 0)
    {
        $users =  self::where('id', '!=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->with('userDetails');

        if($limit > 0)
        {
            $users->limit($limit);
        }

        return $users->get();
    }

    public static function viewUserDetails($id)
    {
        return self::where('id','=',$id)
            ->with('userDetails')
            ->with('Role')
            ->first();
    }
}
