<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('pages.courses', compact('courses'));
    }
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('pages.course_detail', compact('course'));
    }
    public function reserve(Request $request, Course $course)
    {
        return DB::transaction(function () use ($course, $request) {

            // Vérifier les places restantes
            if ($course->remaining_seats <= 0) {
                return back()->withErrors('Aucune place restante pour ce cours.');
            }

            // Empêcher double réservation
            // $alreadyReserved = $course->reservations()
            //     ->where('user_id', $request->user()->id)
            //     ->exists();

            // if ($alreadyReserved) {
            //     return back()->withErrors('Vous avez déjà réservé ce cours.');
            // }

            // Créer la réservation
            $course->reservations()->create([
                // 'user_id' => $request->user()->id,
                'user_id' => 1,
                'reservation_date' => now(),
            ]);

            // Décrémenter les places
            $course->decrement('remaining_seats');

            return back()->with('success', 'Réservation réussie');
        });
       
    }
}
