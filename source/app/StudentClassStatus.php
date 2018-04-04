<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Classes;

class StudentClassStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students_class_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'user_id', 'is_completed'
    ];

    /**
     * Set the Class status completed by student
     * @param $classId
     * @return bool
     */
    public static function setClassCompleted($classId)
    {
        $setCompleted = new StudentClassStatus();
        $setCompleted->class_id = $classId;
        $setCompleted->user_id = Auth::user()->id;
        $setCompleted->is_completed = 1;
        $setCompleted->save();
        if ($setCompleted->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the First records of the class with user id
     * @param $classid
     * @param $userID
     * @return Model|null|static
     */
    public static function isCompletedClass($classid, $userID)
    {
        return self::where([['class_id', '=', $classid], ['user_id', '=', $userID]])->first();
    }
}
