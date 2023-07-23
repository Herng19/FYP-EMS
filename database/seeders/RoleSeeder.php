<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['guard_name' => 'student', 'name' => 'student']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'evaluator']);
        Role::create(['name' => 'head of research group']);
        Role::create(['name' => 'coordinator']);
    }
}
