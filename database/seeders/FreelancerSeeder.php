<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Freelancer;

class FreelancerSeeder extends Seeder
{
    public function run()
    {
        $users = User::inRandomOrder()->take(5)->get(); 

        foreach ($users as $user) {
            Freelancer::create([
                'user_id' => $user->id,
                'country' => fake()->country(),
                'bio' => fake()->paragraph(),
                'specialization' => fake()->jobTitle(),
                'experience' => fake()->text(200),
                'hourly_rate' => fake()->randomFloat(2, 10, 100),
                'portfolio' => fake()->url(),
            ]);

            $user->update(['role' => 'freelancer']);
        }
    }
}
