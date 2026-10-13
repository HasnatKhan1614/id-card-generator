<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        $campuses = [
            [
                'name' => 'Main Campus',
                'email' => 'main@demo-academy.example',
                'contact_number' => '02111111111',
                'address' => '100 Main Street, Demo City',
            ],
            [
                'name' => 'East Campus',
                'email' => 'east@demo-academy.example',
                'contact_number' => '02122222222',
                'address' => '200 East Avenue, Demo City',
            ],
            [
                'name' => 'West Campus',
                'email' => 'west@demo-academy.example',
                'contact_number' => '02133333333',
                'address' => '300 West Road, Demo City',
            ],
        ];

        foreach ($campuses as $campus) {
            Campus::firstOrCreate(
                ['name' => $campus['name']],
                $campus
            );
        }
    }
}
