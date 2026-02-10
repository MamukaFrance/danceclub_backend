<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        return view('pages.courses', compact('courses'));
    }

    // Page pour créer un nouveau post
    public function create()
    {
        $teachers = $this->courseService->getAllTeacgers();
        return view('pages.create-course', compact('teachers'));
    }

    // Page pour éditer un post existant
    public function edit(Course $course)
    {
         $teachers = $this->courseService->getAllTeacgers();
        return view('pages.create-course', compact('course', 'teachers'));
    }

    // Sauvegarde d'un nouveau post
    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        $this->courseService->create($data);
        return redirect()
            ->route('course.index')
            ->with('success', 'Le cours a bien été créé');
    }

    // Mise à jour d'un post existant
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean'
        ]);

        $this->courseService->update($course, $data);

        return redirect()->route('course.index');
    }

    // Supprimer un post
    public function destroy(Course $course)
    {
        $this->courseService->delete($course);
        return redirect()->route('course.index');
    }
}