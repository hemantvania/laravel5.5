<?php

use Illuminate\Database\Seeder;
use App\User;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userroles')->insert(array(
            array('role' => 'Admin','status' => true),
            array('role' => 'School Admin','status' => true),
            array('role' => 'School District','status' => true),
            array('role' => 'Teacher','status' => true),
            array('role' => 'Student','status' => true),
        ));
    }
}
