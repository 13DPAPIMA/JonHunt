<?php

namespace Database\Seeders;

use App\Models\JobAdvertisement;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobAdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем случайных пользователей
        $users = User::inRandomOrder()->take(5)->get();

        // Создаем объявления для первых 5 пользователей
        foreach ($users as $user) {
            JobAdvertisement::factory()->create([
                'creator' => $user->name, // Имя создателя
                'creator_id' => $user->id, // ID создателя
            ]);
        }
    }
}
