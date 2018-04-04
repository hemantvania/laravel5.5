<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RolesCountriesSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(EducationTypeSeeder::class);
        $this->call(UserSuperAdminSeeder::class);
        $this->call(SchoolsSeeder::class);
        $this->call(UserMetaSeeder::class);
        $this->call(SchoolClasses::class);
        $this->call(UsersSchool::class);
        $this->call(StudentsClasses::class);
        $this->call(MaterilasCategory::class);
        $this->call(Materilas::class);
    }
}
