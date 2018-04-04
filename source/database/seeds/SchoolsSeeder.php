<?php

use Illuminate\Database\Seeder;
use App\School;
class SchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $schoolsarr = array(
            array(
                'schoolName'        => 'default school',
                'email'             => 'defaultschool@vdesk.com',
                'registrationNo'    => '123564546',
                'WebUrl'            => 'http://www.defaultshcool.com',
                'logo'              => 'default.jpg',
                'address1'          => 'default address 1',
                'address2'          => 'default address 2',
                'city'              => 'default',
                'state'             => 'default',
                'zip'               => '95600',
                'country'           => 1,
                'facebook_url'      => 'http://www.facebook.com',
                'twitter_url'       => 'http://www.twitter.com',
                'instagram_url'     => 'http://www.instagram.com',
                'schoolType'        => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'schoolName'        => 'default school 2',
                'email'             => 'defaultschool2@vdesk.com',
                'registrationNo'    => '123564546',
                'WebUrl'            => 'http://www.defaultshcool2.com',
                'logo'              => 'default.jpg',
                'address1'          => 'default address 1',
                'address2'          => 'default address 2',
                'city'              => 'default',
                'state'             => 'default',
                'zip'               => '95600',
                'country'           => 1,
                'facebook_url'      => 'http://www.facebook.com',
                'twitter_url'       => 'http://www.twitter.com',
                'instagram_url'     => 'http://www.instagram.com',
                'schoolType'        => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        School::insert($schoolsarr);

    }
}
