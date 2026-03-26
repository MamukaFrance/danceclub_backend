<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        // Générer un ID aléatoire pour l'avatar pour que chaque teacher ait une tête différente
        $avatarId = $faker ->numberBetween(1, 70);

        return [
            'style' => $faker ->randomElement([
                'Ballet', 'Hip Hop', 'Salsa', 
                'Jazz', 'Tap', 'Ballroom'
                ]),
            'bio' => $faker ->paragraph(),
            // URL d'avatar réaliste
            'photo' => "https://i.pravatar.cc/400?img={$avatarId}",
        ];
    }
}
