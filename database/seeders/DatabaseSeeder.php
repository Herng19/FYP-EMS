<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booth;
use App\Models\Venue;
use App\Models\CoLevel;
use App\Models\Project;
use App\Models\Student;
use App\Models\SupervisorList;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use App\Models\IndustrialCoLevel;
use Database\Seeders\LecturerSeeder;
use Database\Seeders\ResearchGroupSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ResearchGroupSeeder::class,
            RoleSeeder::class,
            LecturerSeeder::class, 
        ]);

        Student::create([
            'research_group_id' => 1, 
            'name' => 'Loo Chang Herng', 
            'password' => bcrypt('test'),
            'email' => 'student@example.com', 
            'course' => 'Software Engineering', 
            'psm_year' => '1', 
            'top_student' => '0'
        ])->assignRole('student'); 

        CoLevel::create([
            'co_level_name' => 'CO-1',
            'co_level_description' => 'CO1 Description',
        ]);

        CoLevel::create([
            'co_level_name' => 'CO-2',
            'co_level_description' => 'CO2 Description',
        ]);

        CoLevel::create([
            'co_level_name' => 'CO-3',
            'co_level_description' => 'CO3 Description',
        ]);

        IndustrialCoLevel::create([
            'co_level_name' => 'CO-1',
            'co_level_description' => 'CO3 Description',
        ]);

        IndustrialCoLevel::create([
            'co_level_name' => 'CO-2',
            'co_level_description' => 'CO3 Description',
        ]);

        IndustrialCoLevel::create([
            'co_level_name' => 'CO-3',
            'co_level_description' => 'CO3 Description',
        ]);

        // Set total student number
        define("STUD_NUM", 200);
        
        // Factories call
        Student::factory()->count(STUD_NUM - 1)->create();
        Project::factory()->count(STUD_NUM)->create();
        Venue::factory()->count(20)->create();
        Booth::factory()->count(STUD_NUM)->create();
        SupervisorList::factory()->count(STUD_NUM)->create();
    }
}
