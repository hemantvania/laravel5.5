<?php

use Illuminate\Database\Seeder;
use App\EducationType;

class EducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educationtypes = array(
			array(
			    'educationName' => 'Masters/Diploma/PG Cert',
                'isActive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
			array(
			    'educationName' => 'MBA',
                'isActive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
			array(
			    'educationName' => 'Research',
                'isActive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
			array(
			    'educationName' => 'LLM',
                'isActive' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            
        );
        EducationType::insert($educationtypes);
    }
}
