<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UsersAtivityTracker;
use Carbon\Carbon;
use Config;

class CronSetLogoutTimeToExpiredSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoLogout:set-logout-time-to-expired-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto set logout time and total logged in time to expired session';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $noneLoggedOutUsers = UsersAtivityTracker::where('logged_out_time','=','0000-00-00 00:00:00')->get();

        if(count($noneLoggedOutUsers) > 0 )
        {
            foreach ($noneLoggedOutUsers as $user)
            {
                $to = Carbon::createFromFormat('Y-m-d H:s:i', $user->logged_in_time);
                $from = Carbon::createFromFormat('Y-m-d H:s:i', $user->updated_at);
                $diff_in_minutes = $to->diffInMinutes($from);

                $nowTime    = Carbon::now();
                $lastActivityDiff   = $nowTime->diffInMinutes($user->updated_at,true);

                if($lastActivityDiff > Config::get('session.lifetime') ) {
                    UsersAtivityTracker::where('id','=',$user->id)->update(['logged_out_time'=>$user->updated_at,'total'=>$diff_in_minutes]);
                }
            }

            $this->info('All updated Successfully!');
        }
    }
}
