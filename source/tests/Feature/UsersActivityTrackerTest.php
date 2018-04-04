<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\UsersAtivityTracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Auth;
class UsersActivityTrackerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * Activate the tracker when user logged into the system
     */
    public function activateTracker(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $id = Auth::user()->id;
        $loggedtime = Carbon::now();
        $clientip   = '';
        $browser    = '';
        $logout     = Carbon::today();
        $activity   = new UsersAtivityTracker();
        $activityid = $activity->activateTracker($id,$clientip,$browser,$loggedtime,$logout);
        $this->assertInternalType("int",$activityid);
    }

    /**
     * @test
     *
     * deactivate Tracker when user logged out
     */
    public function deactivateTracker(){
        $teacher = User::where('userrole','=','2')->first();
        $this->signIn($teacher);
        $id = Auth::user()->id;
        $loggedtime = Carbon::now();
        $clientip   = '';
        $browser    = '';
        $logout     = Carbon::today();
        $activity   = new UsersAtivityTracker();
        $activityid = $activity->activateTracker($id,$clientip,$browser,$loggedtime,$logout);

        $loggedintime   = Carbon::createFromTimestamp(strtotime($loggedtime));
        $loggedtime     = Carbon::now();
        $diffhours      = $loggedintime->diffInMinutes($loggedtime,true);
        $activity       = new UsersAtivityTracker();
        $deactivate =  $activity->deactivateTracker($activityid,$loggedtime,$diffhours);
        $this->assertTrue(true,$deactivate);
    }

    /**
     * @test
     *
     * Function is used to get users activity average time in site.
     */
    public function getUserActivityAvg(){
        $objactivity   = new UsersAtivityTracker();
        $list = $objactivity->getUserActivityAvg();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
    }
}
