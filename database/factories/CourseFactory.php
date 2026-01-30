<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$faker = \Faker\Factory::create('fr_FR'); // <-- français //
        // il faut suprimer this partout
        $capacity = $this->faker->numberBetween(10, 30);

        return [
            'teacher_id' => \App\Models\Teacher::factory(),
            'title' => $this->faker->sentence(3),
            'style' => $this->faker->randomElement(['Ballet', 'Hip Hop', 'Salsa', 'Contemporary', 'Jazz', 'Tap', 'Ballroom']),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'capacity' => $capacity,
            'remaining_seats' => $capacity,
            'date' => $this->faker->date(),
            'start_time' => $this->faker->time('H:i:s', '18:00:00'),
            'end_time' => $this->faker->time('H:i:s', '19:00:00'),
            'description' => $this->faker->paragraph(),            
        ];
    }
}
