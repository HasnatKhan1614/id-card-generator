<?php

namespace Database\Factories;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class CampusFactory extends Factory
{
    protected $model = Campus::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company() . ' Campus',
            'email' => fake()->unique()->companyEmail(),
            'contact_number' => fake()->numerify('021########'),
            'address' => fake()->streetAddress() . ', ' . fake()->city(),
        ];
    }
}
