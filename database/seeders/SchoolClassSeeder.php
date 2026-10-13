<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            'Nursery',
            'Kindergarten',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10',
        ];

        foreach ($classes as $index => $name) {
            SchoolClass::firstOrCreate(
                ['name' => $name],
                [
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ]
            );
        }
    }
}
