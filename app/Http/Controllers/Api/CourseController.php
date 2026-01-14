<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all());
    }

    public function show($id)
    {
        $course = Course::find($id);
        if ($course) {
            return response()->json($course);
        } else {
            return response()->json(['message' => 'Course not found'], 404);
        }
    }

    public function reserveCourse(Request $request, Course $course)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    return DB::transaction(function () use ($course, $request) {

        // Vérifier les places restantes
        if ($course->remaining_seats <= 0) {
            return response()->json([
                'message' => 'Plus de places disponibles'
            ], 400);
        }

        // Empêcher double réservation
        $alreadyReserved = $course->reservations()
            ->where('user_id', $request->user_id)
            ->exists();

        if ($alreadyReserved) {
            return response()->json([
                'message' => 'Vous avez déjà réservé ce cours'
            ], 409);
        }

        // Créer la réservation
        $course->reservations()->create([
            'user_id' => $request->user_id,
            'reservation_date' => now(),
        ]);

        // Décrémenter les places
        $course->decrement('remaining_seats');

        return response()->json([
            'message' => 'Cours réservé avec succès'
        ], 200);
    });
}

}
