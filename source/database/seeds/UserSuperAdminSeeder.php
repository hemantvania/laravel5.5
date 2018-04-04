<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('name' => 'Super Admin', 'first_name' => 'Super','last_name' => 'Admin','email' => 'hardik.soni@gatewaytechnolabs.com','password' => Hash::make(123456),'userrole' => 1),

            array(
                'name'       => 'Ari Hartikainen',
                'first_name' => 'Ari',
                'last_name'  => 'Hartikainen',
                'email'      => 'admin@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 5

            ),

            array(
                'name'       => 'Duck Luwis',
                'first_name' => 'Duck',
                'last_name'  => 'Luwis',
                'email'      => 'schooldistrict@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 4),
            array(
                'name'       => 'Adam Doe ',
                'first_name' => 'Adam',
                'last_name'  => 'Doe',
                'email'      => 'teacher@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 2),
            array(
                'name'       => 'John Levis ',
                'first_name' => 'John',
                'last_name'  => 'Levis',
                'email'      => 'student@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 3),
            array(
                'name'       => 'Jammy Doe ',
                'first_name' => 'Jammy',
                'last_name'  => 'Doe',
                'email'      => 'schooladmin@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 6),

            array(
                'name'       => 'School District',
                'first_name' => 'School',
                'last_name'  => 'District',
                'email'      => 'schooldistrict2@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 4),
            array(
                'name'       => 'Teacer doe ',
                'first_name' => 'Teacher',
                'last_name'  => 'Doe',
                'email'      => 'teacher2@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 2),
            array(
                'name'       => 'Student Levis ',
                'first_name' => 'Student',
                'last_name'  => 'Levis',
                'email'      => 'student2@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 3),
            array(
                'name'       => 'School Admin ',
                'first_name' => 'School',
                'last_name'  => 'Admin',
                'email'      => 'schooladmin2@vdesk.com',
                'password'   => Hash::make(123456),
                'userrole'   => 6),

        );

        User::insert($users);
    }
}
