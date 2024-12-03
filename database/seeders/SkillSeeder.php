<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Web Development',
            'Graphic Design',
            'Content Writing',
            'Digital Marketing',
            'SEO',
            'Mobile App Development',
            'UI/UX Design',
            'Project Management',
            'Data Analysis',
        ];

        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }
    }
}
