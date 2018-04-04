<?php

use Illuminate\Database\Seeder;
use App\UserMeta;
class UserMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $usersMeta = array(
            array(
                 'userId'       => 2,
                 'phone'        =>'132121321',
                 'profileimage' =>'',
                 'addressline1' => 'address1',
                 'addressline2' =>'address2',
                 'ssn'          => '3131321',
                 'city'         =>'Ahemandabad',
                 'country'      => 1,
                 'zip'          =>'36565',
                 'gender'       =>'1',
                 'enable_share_screen' =>'1',
                 'default_school' =>1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'userId'       => 3,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
           ),
            array(
                'userId'       => 4,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
             array(
                 'userId'       => 5,
                 'phone'        =>'132121321',
                 'profileimage' =>'',
                 'addressline1' => 'address1',
                 'addressline2' =>'address2',
                 'ssn'          => '3131321',
                 'city'         =>'Ahemandabad',
                 'country'      => 1,
                 'zip'          =>'36565',
                 'gender'       =>'1',
                 'enable_share_screen' =>'1',
                 'default_school' => 1,
                 'created_at' => new \DateTime(),
                 'updated_at' => new \DateTime()
             ),
            array(
                'userId'       => 6,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'userId'       => 7,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'userId'       => 8,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'userId'       => 9,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'userId'       => 10,
                'phone'        =>'132121321',
                'profileimage' =>'',
                'addressline1' => 'address1',
                'addressline2' =>'address2',
                'ssn'          => '3131321',
                'city'         =>'Ahemandabad',
                'country'      => 1,
                'zip'          =>'36565',
                'gender'       =>'1',
                'enable_share_screen' =>'1',
                'default_school' => 2,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            )

        );
        UserMeta::insert($usersMeta);
    }
}
