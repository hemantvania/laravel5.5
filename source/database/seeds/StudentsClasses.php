<?php

use Illuminate\Database\Seeder;
use App\UsersClasses;
class StudentsClasses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $usersClasses = array(
            array(
                'class_id'  =>1,
                'user_id'   =>3,
                'sequence'  =>0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'class_id'  =>1,
                'user_id'   =>4,
                'sequence'  =>0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'class_id'  =>1,
                'user_id'   =>5,
                'sequence'  =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'class_id'  =>6,
                'user_id'   =>7,
                'sequence'  =>0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'class_id'  =>6,
                'user_id'   =>8,
                'sequence'  =>0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'class_id'  =>6,
                'user_id'   =>9,
                'sequence'  =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            )
        );
        UsersClasses::insert($usersClasses);
    }
}
