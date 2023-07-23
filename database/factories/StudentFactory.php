<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'research_group_id' => $this->faker->numberBetween(1, 11),
            'student_name' => $this->faker->name,
            'password' => $this->faker->password,
            'email' => $this->faker->unique()->safeEmail,
            'course' => $this->faker->randomElement(['Software Engineering', 'Graphics Design & Animation', 'Data & Networking']),
            'psm_year' => $this->faker->randomElement(['1', '2']),
            'top_student' => $this->faker->boolean(),
        ];
    }

    public function configure(){
            return $this->afterCreating(function (Student $student) {
                $student->assignRole('student');
        });
    }
}
