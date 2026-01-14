<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'style' => $this->faker->randomElement(['Ballet', 'Hip Hop', 'Salsa', 'Contemporary', 'Jazz', 'Tap', 'Ballroom']),
            'bio' => $this->faker->paragraph(),
            'photo' => $this->faker->imageUrl(400, 400, 'people'),
        ];
    }
}
