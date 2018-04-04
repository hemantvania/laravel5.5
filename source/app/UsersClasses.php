<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StudentActivity;

class UsersClasses extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'user_id', 'sequence'
    ];

    /**
     * Building relation with classes model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classes()
    {
        return $this->belongsTo('App\Classes');
    }

    /**
     * Define relation with User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Defining relation for Classes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentClass()
    {
        return $this->belongsTo('App\Classes', 'class_id');
    }

    /**
     * Defining the relation for StudentActivity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function completedClass()
    {
        return $this->belongsTo('App\StudentActivity', 'class_id');
    }

    /**
     * This will assign all user to class Used in SchoolController storeClass
     * @param $users
     * @param $classId
     */
    public function assignClass($users, $classId)
    {
        if (!empty($classId)) {
            UsersClasses::join('users', 'user_id', 'users.id')
                ->where('class_id', '=', $classId)
                ->where('users.userrole', '=', '2')
                ->delete();
        }
        if (is_array($users) && count($users) > 0) {
            foreach ($users as $user) {
                $this->assignStudent($user, $classId, 0);
            }
        }
    }

    /**
     * Return all assigned teachers in a class by class id
     * @param $classId
     * @return array
     */
    public function getTeachersOfClass($classId)
    {
        return self::select('user_id')
            ->join('users', 'users.id', '=', 'users_classes.user_id')
            ->where('users.userrole', '=', '2')
            ->where('class_id', '=', $classId)->pluck('user_id')->toArray();
    }

    /**
     * Return Total Number of count for specific user assign to specific class
     * @param $studentid
     * @return int
     */
    public function getAssignStudentCount($studentid)
    {
        return UsersClasses::where('user_id', '=', $studentid)
            ->get()->count();
    }

    /**
     * Assign Student To Specific Class
     * @param $studentid
     * @param $classid
     * @param $sequence
     */
    public function assignStudent($studentid, $classid, $sequence)
    {
        self::insert([
            [
                'user_id'  => $studentid,
                'class_id' => $classid,
                'sequence' => $sequence
            ],
        ]);
    }

    /**
     * Get the class max sequence
     * @param $classid
     * @return mixed
     */
    public function getClassLastSequence($classid)
    {
        return UsersClasses::where('class_id', '=', $classid)
            ->max('sequence');
    }

    /**
     * Delete all teacher from specific class
     * @param $classId
     */
    public function deleteUserClass($classId){
            self::join('users', 'user_id', 'users.id')
                ->where('class_id', '=', $classId)
                ->where('users.userrole', '=', '2')
                ->delete();
    }


}
