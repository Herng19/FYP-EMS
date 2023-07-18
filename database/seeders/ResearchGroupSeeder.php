<?php

namespace Database\Seeders;

use App\Models\ResearchGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResearchGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(DB::table('research_groups')->count() == 0){
            ResearchGroup::insert([
            [
                'research_group_name' => 'Computer System Research Group',
                'research_group_short_form' => 'CSRG', 
            ], 
            [
                'research_group_name' => 'Virtual Simulation & Computing',
                'research_group_short_form' => 'VISIC', 
            ], 
            [
                'research_group_name' => 'Machine Intelligence Research Group',
                'research_group_short_form' => 'MIRG',
            ], 
            [
                'research_group_name' => 'Cyber Security Interest Group',
                'research_group_short_form' => 'Cy-SIG',
            ], 
            [
                'research_group_name' => 'Software Engineering Research Group',
                'research_group_short_form' => 'SERG',
            ], 
            [
                'research_group_name' => 'Knowledge Engineering & Computational Linguistic',
                'research_group_short_form' => 'KECL',
            ], 
            [
                'research_group_name' => 'Data Science & Simulation Modeling',
                'research_group_short_form' => 'DSSim',
            ], 
            [
                'research_group_name' => 'Database Technology & Information System',
                'research_group_short_form' => 'DBIS',
            ], 
            [
                'research_group_name' => 'Educational Technology (EduTech)',
                'research_group_short_form' => 'EDU-TECH',
            ], 
            [
                'research_group_name' => 'Image Signal Processing',
                'research_group_short_form' => 'ISP',
            ], 
            [
                'research_group_name' => 'Computer Network & Research Group',
                'research_group_short_form' => 'CNRG',
            ], 
            [
                'research_group_name' => 'Soft Computing & Optimization',
                'research_group_short_form' => 'SCORE',
            ]
        ]);
        }
    }
}
