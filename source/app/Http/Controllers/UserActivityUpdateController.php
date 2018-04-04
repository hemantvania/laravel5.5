<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\UsersAtivityTracker;
use App\Http\Custom\Helper;
use Config;
use Carbon\Carbon;

class UserActivityUpdateController extends Controller
{
    /**
     * This function is called from browser event
     * to set current activity time on updated_at to auth user
     * Will call by ajax
     */
    public function AuthActivityUpdate()
    {
        $activityId = session('useractivity_id');
        //Log::error('activity id '.$activityId );
        if (!empty($activityId)) {
            UsersAtivityTracker::find($activityId)->touch();
        }
    }
}
