<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'length_in_seconds' => $this->faker->numberBetween(60, 120) * 60,
            'released_at' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'available_until' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
