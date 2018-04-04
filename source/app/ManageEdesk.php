<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageEdesk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'class_id', 'teacher_id', 'is_active'
    ];

    /**
     * Insert Records to Manage Edesk On / Off
     * @param $studentid
     * @param $classid
     * @param $teacherid
     * @param $status
     * @return int
     */
    public function insertToManageEdesk($studentid, $classid, $teacherid, $status)
    {
        return self::insertGetId(
            [
                'student_id' => $studentid,
                'class_id' => $classid,
                'teacher_id' => $teacherid,
                'is_active' => $status,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }

    /**
     * Get Records By Id
     * @param $studentid
     * @param $classid
     * @param $teacherid
     * @return Model|null|static
     */
    public function getManageEdeskByStudentClassID($studentid, $classid, $teacherid = '')
    {
        return self::where('student_id', $studentid)
            ->where('class_id', $classid)
            ->where('teacher_id', $teacherid)
            ->select('id', 'is_active')
            ->first();
    }

    /**
     * Update Status Based on Id
     * @param $id
     * @param $status
     */
    public function updateManageEdeskById($id, $status)
    {
        self::where('id', $id)
            ->update(['is_active' => $status]);
    }

    /**
     * Students Get his Class status
     * @param $studentid
     * @param $classid
     * @return Model|null|static
     */
    public function getManageEdeskByStudent($studentid, $classid)
    {
        return self::where('student_id', $studentid)
            ->where('class_id', $classid)
            ->select('id', 'is_active')
            ->first();
    }
}
