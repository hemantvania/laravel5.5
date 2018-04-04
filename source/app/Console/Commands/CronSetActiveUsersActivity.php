<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UsersAtivityTracker;
use App\Http\Custom\Helper;


class CronSetActiveUsersActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:set-active-user-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set current activity time as updated_at to all active users';

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
        $loggedUsers = Helper::loggedUsers();

        if(count($loggedUsers) > 0 )
        {
            foreach ($loggedUsers as $user)
            {
                UsersAtivityTracker::where('user_id','=',$user->id )->orderBy('id', 'desc')->first()->touch();

                $this->info('ID: '.$user->id.' has updated Successfully!');
            }

            $this->info('All updated Successfully!');
        }
    }
}
