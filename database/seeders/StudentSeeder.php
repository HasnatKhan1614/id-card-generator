<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Seed demo students for local development and demos.
     */
    public function run(): void
    {
        $demoStudents = [
            [
                'sid' => 'SID-1001',
                'campus' => 'Main Campus',
                'class' => 'Grade 1',
                'first_name' => 'Alex',
                'last_name' => 'Morgan',
                'student_name' => 'Alex Morgan',
                'is_registered' => false,
            ],
            [
                'sid' => 'SID-1002',
                'campus' => 'Main Campus',
                'class' => 'Grade 3',
                'first_name' => 'Jamie',
                'last_name' => 'Lee',
                'student_name' => 'Jamie Lee',
                'father_name' => 'Chris Lee',
                'phone' => '03001234567',
                'dob' => '2016-05-12',
                'address' => '12 Oak Street, Demo City',
                'is_registered' => true,
            ],
            [
                'sid' => 'SID-1003',
                'campus' => 'East Campus',
                'class' => 'Kindergarten',
                'first_name' => 'Sam',
                'last_name' => 'Patel',
                'student_name' => 'Sam Patel',
                'is_registered' => false,
            ],
            [
                'sid' => 'SID-1004',
                'campus' => 'West Campus',
                'class' => 'Grade 8',
                'first_name' => 'Taylor',
                'last_name' => 'Brooks',
                'student_name' => 'Taylor Brooks',
                'father_name' => 'Jordan Brooks',
                'phone' => '03111234567',
                'dob' => '2012-09-20',
                'address' => '88 River Road, Demo City',
                'is_registered' => true,
            ],
            [
                'sid' => 'SID-1005',
                'campus' => 'East Campus',
                'class' => 'Grade 5',
                'first_name' => 'Riley',
                'last_name' => 'Nguyen',
                'student_name' => 'Riley Nguyen',
                'father_name' => 'Minh Nguyen',
                'phone' => '03211234567',
                'dob' => '2014-01-08',
                'address' => '45 Hill Lane, Demo City',
                'is_registered' => true,
            ],
        ];

        foreach ($demoStudents as $student) {
            Student::firstOrCreate(
                ['sid' => $student['sid']],
                $student
            );
        }

        Student::factory()->count(10)->create();
        Student::factory()->count(5)->registered()->create();
    }
}
