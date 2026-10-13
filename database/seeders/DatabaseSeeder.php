<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            CampusSeeder::class,
            SchoolClassSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
