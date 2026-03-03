<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {
            // Chaque teacher a entre 3 et 5 cours
            $courseCount = rand(3, 5);

            Course::factory()
                ->count($courseCount)
                ->create([
                    'teacher_id' => $teacher->id,
                    'style' => $teacher->style,
                ]);
        }
    }
}
