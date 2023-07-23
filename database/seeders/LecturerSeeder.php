<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create(['research_group_id' => 1,
        'lecturer_name' => 'En.Zulfahmi',
        'email' => 'zulfahmi@ump.edu.my',
        'email_verified_at' => now(),
        'password' => bcrypt('password'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'coordinator');

        Lecturer::factory()->count(30)->create();
    }
}
