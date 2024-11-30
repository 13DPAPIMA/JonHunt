<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'creator' => $this->faker->name, // Связываем с существующим или создаем нового пользователя
            'description' => $this->faker->paragraph,
            'niche' => $this->faker->word,
            'completion_date' => $this->faker->date(),
            'budget' => $this->faker->randomFloat(2, 50, 1000),
            'status' => 'open',
        ];
    }
}
