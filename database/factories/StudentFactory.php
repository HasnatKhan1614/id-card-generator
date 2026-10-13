<?php

namespace Database\Factories;

use App\Models\Campus;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $campuses = Campus::names() ?: ['Main Campus'];
        $classes = SchoolClass::names() ?: ['Grade 1'];

        return [
            'sid' => 'SID-' . fake()->unique()->numerify('####'),
            'campus' => fake()->randomElement($campuses),
            'class' => fake()->randomElement($classes),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'student_name' => $firstName . ' ' . $lastName,
            'father_name' => null,
            'phone' => null,
            'dob' => null,
            'address' => null,
            'image' => null,
            'is_registered' => false,
        ];
    }

    public function registered(): static
    {
        return $this->state(fn (array $attributes) => [
            'father_name' => fake()->name(),
            'phone' => fake()->numerify('03#########'),
            'dob' => fake()->date('Y-m-d', '-8 years'),
            'address' => fake()->streetAddress() . ', ' . fake()->city(),
            'is_registered' => true,
        ]);
    }
}
