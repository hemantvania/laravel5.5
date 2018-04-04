<?php

use Illuminate\Database\Seeder;
use App\Userrole;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rolesarr = array(
			array(
			    'rolename' => 'Super Admin',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
			array(
			    'rolename' => 'Teacher',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
			array(
			    'rolename' => 'Student',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'rolename' => 'School District',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'rolename' => 'Portal Admin',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'rolename' => 'School Admin',
                'isactive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        Userrole::insert($rolesarr);
    }
}
