<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UsersAtivityTracker extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_ativity_trackers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_ip', 'browser', 'logged_in_time', 'logged_out_time', 'total'
    ];

    /**
     * Activate the tracker when user logged into the system
     * @param $userid
     * @param $ip
     * @param $browser
     * @param $time
     * @return int
     */
    public function activateTracker($userid, $ip, $browser, $time, $logout)
    {
        return self::insertGetId(
            [
                'user_id' => $userid,
                'client_ip' => $ip,
                'browser' => $browser,
                'logged_in_time' => $time,
                'logged_out_time' => $logout,
                'total' => '00',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }

    /**
     * deactivate Tracker when user logged out
     * @param $id
     * @param $outtime
     * @param $total
     */
    public function deactivateTracker($id, $outtime, $total)
    {
        self::where('id', $id)
            ->update([
                'logged_out_time' => $outtime,
                'total' => $total,
                'updated_at' => new \DateTime()
            ]);
    }

    /**
     * Function is used to get users activity average time in site.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserActivityAvg()
    {
        $avgCount = self::join('users as u', 'user_id', '=', 'u.id')
            ->join('userroles as role', 'u.userrole', '=', 'role.id')
            ->whereIn('u.userrole', array(2, 3, 4, 6))
            ->select(['role.rolename', DB::raw("SUM(total) / count(DISTINCT user_id) as avgtime")])
            ->groupBy('u.userrole')
            ->get();
        return $avgCount;
    }
}
