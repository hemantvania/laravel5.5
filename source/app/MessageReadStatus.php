<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageReadStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','message_id','user_id','created_at','updated_at'
    ];
}
