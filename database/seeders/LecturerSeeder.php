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

        Lecturer::create(['research_group_id' => 1,
        'name' => 'CSRG Head',
        'email' => 'csrg@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 2,
        'name' => 'VISIC Head',
        'email' => 'visic@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 3,
        'name' => 'MIRG Head',
        'email' => 'mirg@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 4,
        'name' => 'Cy-SIG Head',
        'email' => 'cy-sig@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 5,
        'name' => 'SERG Head',
        'email' => 'serg@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 6,
        'name' => 'KECL Head',
        'email' => 'kecl@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 7,
        'name' => 'DSSim Head',
        'email' => 'dssim@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 8,
        'name' => 'DBIS Head',
        'email' => 'dbis@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 9,
        'name' => 'EDUTECH Head',
        'email' => 'edutech@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 10,
        'name' => 'ISP Head',
        'email' => 'isp@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 11,
        'name' => 'CNRG Head',
        'email' => 'cnrg@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::create(['research_group_id' => 12,
        'name' => 'SCORE Head',
        'email' => 'score@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('test'), // password
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'remember_token' => Str::random(10),
        'profile_photo_path' => null,
        'current_team_id' => null,])->assignRole('supervisor', 'evaluator', 'head of research group');

        Lecturer::factory()->count(87)->create();
    }
}
