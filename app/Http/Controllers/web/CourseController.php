<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Course;

use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{
    public function __construct(protected CourseService $courseService) {
         // Middleware pour sécuriser certaines routes par rôle
        $this->middleware('role:admin|editor')->only(['create', 'store', 'edit', 'update']);
    }

    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        return view('web.pages.courses.index', compact('courses'));
    }

    // Page pour créer un nouveau post
    public function create()
    {
        $teachers = $this->courseService->getAllTeachers();
        return view('web.pages.courses.create', compact('teachers'));
    }

    // Page pour éditer un post existant
    public function edit(Course $course)
    {
         $teachers = $this->courseService->getAllTeachers();
        return view('web.pages.courses.edit', compact('course', 'teachers'));
    }

    // Sauvegarde d'un nouveau post
    public function store(CourseRequest $request)
    {
        try {
            $data = $request->validated();
            $this->courseService->create($data);
            return redirect()
                ->route('courses.index')
                ->with('success', 'Le cours a bien été créé');
        }catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
       
    }

    // Page pour afficher un Post
    public function show(Course $course)
    {
        return view('web.pages.courses.show', compact('course'));
    }

    // Mise à jour d'un post existant
    public function update(CourseRequest $request, Course $course)
    {
        try {        
            $data = $request->validated();
            if(! $course->wasChanged()) {
                return redirect()
                    ->route('courses.index')
                    ->with('info', 'Aucun changement détecté');
            }
            $this->courseService->update($course, $data);
            return redirect()
                ->route('courses.index')
                ->with('success', 'Le cours a bien été mis à jour');
        }catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Supprimer un post
    public function destroy(Course $course)
    {
        try{
            $this->courseService->delete($course);
            return redirect()->route('courses.index')
                ->with('success', 'Le cours a bien été supprimé');   
        }catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
        
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
                'user_id' => $request->user()->id,
                'reservation_date' => now(),
            ]);

            // Décrémenter les places
            $course->decrement('remaining_seats');

            return back()->with('success', 'Réservation réussie');
        });
       
    }
}