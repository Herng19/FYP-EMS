<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupervisorList>
 */
class SupervisorListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $number = 1; 

        $student = Student::find($number); 
        $lecturers = Lecturer::where('research_group_id', $student->research_group_id)->pluck('lecturer_id')->toArray();

        return [
            'student_id' => $number++,
            'lecturer_id' => $this->faker->randomElement($lecturers),
        ];
    }
}
