<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $users = User::inRandomOrder()->take(5)->get();

        foreach ($users as $user) {
            Project::create([
                'title' => fake()->sentence(),
                'creator_id' => $user->id,
                'description' => fake()->paragraph(),
                'niche' => fake()->word(),
                'completion_date' => fake()->date(),
                'budget' => fake()->randomFloat(2, 100, 1000),
                'status' => 'open',
            ]);
        }
    }
}
