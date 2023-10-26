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
        'name' => 'En.Zulfahmi',
        'email' => 'coordinator@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'coordinator');

        Lecturer::factory()->count(80)->create();
    }
}
