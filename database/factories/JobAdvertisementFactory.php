<?php

namespace Database\Factories;

use App\Models\JobAdvertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobAdvertisementFactory extends Factory
{
    protected $model = JobAdvertisement::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(4),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'examples' => null, // Можно добавить путь к файлу, если потребуется
        ];
    }
}
