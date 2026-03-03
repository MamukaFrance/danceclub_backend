<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
   {
        // Récupérer tous les editors
        $editors = User::role('editor')->get();

        foreach ($editors as $index => $editor) {
            // Créer un teacher pour chaque editor 
            Teacher::factory()->create([
                'user_id' => $editor->id,
            ]);
        }
    }
}
