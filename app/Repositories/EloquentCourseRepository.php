<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\User;
use App\Repositories\Contracts\CourseRepositoryInterface;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function create(array $data): Course
    {
        return Course::create($data);
    }

     public function all()
    {
        return Course::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): ?Course
    {
        return Course::find($id);
    }

     public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course;
    }

     public function delete(Course $course): bool
    {
        return $course->delete();
    }

    public function getAllTeacgers()
    {
        return User::where('role', 'teacher')->get();
    }
}