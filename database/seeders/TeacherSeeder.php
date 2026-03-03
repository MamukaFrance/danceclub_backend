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
        // Définir des styles fixes
        $styles = ['Ballet', 'Hip Hop', 'Salsa', 'Jazz', 'Tap', 'Ballroom'];

        foreach ($editors as $index => $editor) {
            // Créer un teacher pour chaque editor
            $teacher = Teacher::create([
                'user_id' => $editor->id,
                'style' => $styles[$index % count($styles)],
                'bio' => "Bio par défaut pour le teacher {$editor->name}", // texte fixe
                'photo' => "https://i.pravatar.cc/400?img=" . ($index + 1), // avatar fixe
            ]);
        }
    }
}
