<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use Faker\Factory as FakerFactory;

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
        // Instancie Faker manuellement pour être sûr qu'il marche en prod
        $faker = FakerFactory::create();
        // Choisir un teacher existant
        $teacher = Teacher::inRandomOrder()->firstOrFail();

        // Capacité du cours
        $capacity = $faker->numberBetween(10, 30);

        // Générer un horaire réaliste
        $startHour = $faker->numberBetween(8, 20); // entre 8h et 20h
        $startMinute = $faker->randomElement([0, 15, 30, 45]);
        $start_time = sprintf('%02d:%02d:00', $startHour, $startMinute);
        $end_time = date('H:i:s', strtotime($start_time . ' +1 hour'));

        return [
            'teacher_id' => $teacher->id,
            'title' => $faker->sentence(3),
            'style' => $teacher->style,
            'level' => $faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'capacity' => $capacity,
            'remaining_seats' => $capacity,
            'date' => $faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'description' => $faker->paragraph(),
        ];
    }
}
