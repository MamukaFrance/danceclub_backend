<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function __construct(protected CourseService $courseService) {
         // Middleware pour sécuriser certaines routes par rôle
        $this->middleware('role:admin|editor')->only(['create', 'store', 'edit', 'update']);
    }

    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        return view('pages.courses', compact('courses'));
    }

    // Page pour créer un nouveau post
    public function create()
    {
        $teachers = $this->courseService->getAllTeachers();
        return view('pages.create-course', compact('teachers'));
    }

    // Page pour éditer un post existant
    public function edit(Course $course)
    {
         $teachers = $this->courseService->getAllTeachers();
        return view('pages.create-course', compact('course', 'teachers'));
    }

    // Sauvegarde d'un nouveau post
    public function store(CourseRequest $request)
    {
        try {
            $data = $request->validated();
            $this->courseService->create($data);
            return redirect()
                ->route('course.index')
                ->with('success', 'Le cours a bien été créé');
        }catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
       
    }

    // Mise à jour d'un post existant
    public function update(CourseRequest $request, Course $course)
    {
        try {        
            $data = $request->validated();
            $this->courseService->update($course, $data);
            return redirect()
                ->route('course.index')
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
            return redirect()->route('course.index')
                ->with('success', 'Le cours a bien été supprimé');   
        }catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
        
    }
}