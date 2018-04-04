<?php

use Illuminate\Database\Seeder;
use App\Classes;
class SchoolClasses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $schoolClasses = array(
            array(
                'className'         =>'eDesk 01',
                'schoolId'          =>1,
                'educationTypeId'   =>1,
                'standard'          =>'standard 1',
                'class_duration'    =>20,
                'class_size'        =>15,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk 02',
                'schoolId'          =>1,
                'educationTypeId'   =>1,
                'standard'          =>'standard 2',
                'class_duration'    =>30,
                'class_size'        =>40,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk 03',
                'schoolId'          =>1,
                'educationTypeId'   =>1,
                'standard'          =>'standard 3',
                'class_duration'    =>30,
                'class_size'        =>20,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk 04',
                'schoolId'          =>1,
                'educationTypeId'   =>1,
                'standard'          =>'standard 4',
                'class_duration'    =>30,
                'class_size'        =>30,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk 05',
                'schoolId'          =>1,
                'educationTypeId'   =>1,
                'standard'          =>'standard 5',
                'class_duration'    =>30,
                'class_size'        =>20,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),

            array(
                'className'         =>'eDesk Test 01',
                'schoolId'          =>2,
                'educationTypeId'   =>1,
                'standard'          =>'standard 1',
                'class_duration'    =>20,
                'class_size'        =>15,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk test 02',
                'schoolId'          =>2,
                'educationTypeId'   =>1,
                'standard'          =>'standard 2',
                'class_duration'    =>30,
                'class_size'        =>40,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk test 03',
                'schoolId'          =>2,
                'educationTypeId'   =>1,
                'standard'          =>'standard 3',
                'class_duration'    =>30,
                'class_size'        =>20,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk test 04',
                'schoolId'          =>2,
                'educationTypeId'   =>1,
                'standard'          =>'standard 4',
                'class_duration'    =>30,
                'class_size'        =>30,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
            array(
                'className'         =>'eDesk test  05',
                'schoolId'          =>2,
                'educationTypeId'   =>1,
                'standard'          =>'standard 5',
                'class_duration'    =>30,
                'class_size'        =>20,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ),
        );
        Classes::insert($schoolClasses);
    }
}
