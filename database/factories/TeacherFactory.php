<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Factory as FakerFactory;

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
        // Instancie Faker manuellement pour être sûr qu'il marche en prod
        $faker = FakerFactory::create();
        // Générer un ID aléatoire pour l'avatar pour que chaque teacher ait une tête différente
        $avatarId = $faker->numberBetween(1, 70);

        return [
            'style' => $faker->randomElement([
                'Ballet', 'Hip Hop', 'Salsa', 
                'Jazz', 'Tap', 'Ballroom'
                ]),
            'bio' => $faker->paragraph(),
            // URL d'avatar réaliste
            'photo' => "https://i.pravatar.cc/400?img={$avatarId}",
        ];
    }
}
