<?php

use Illuminate\Database\Seeder;
use App\UsersSchools;
class UsersSchool extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $usersSchool = array(
            array(
                'user_id'   =>3,
                'school_id' =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>4,
                'school_id' =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>5,
                'school_id' =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>6,
                'school_id' =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>7,
                'school_id' =>2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>8,
                'school_id' =>2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>9,
                'school_id' =>2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'user_id'   =>10,
                'school_id' =>2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        UsersSchools::insert($usersSchool);
    }
}
