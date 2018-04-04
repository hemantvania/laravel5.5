<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Classes;

class StudentActivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'user_id', 'material_id', 'is_completed'
    ];


}
