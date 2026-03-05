<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\User;
use App\Models\Teacher;
use App\Repositories\Contracts\CourseRepositoryInterface;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function create(array $data): Course
    {
        return Course::create($data);
    }

     public function all()
    {
        return Course::withCount([
                'reservations as is_reserved' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();
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

    public function getAllTeachers()
    {
        // return User::where('role', 'teacher')->get();
        return Teacher::with('user')->get();
    }

    public function reserve(Course $course, int $userId)
    {
        $created = $course->reservations()->create([
            'user_id' => $userId,
            'course_id' => $course->id,
            'reservation_date' => now() 
        ]);
        if ($created) {
            $course->decrement('remaining_seats');
        }
        return $course;
    }

    public function cancel(Course $course, int $userId)
    {
         $deleted = $course->reservations()
            ->where('user_id', $userId)
            ->first()
            ->delete();
        if ($deleted) {
            $course->increment('remaining_seats');
        }
        return $course;
    }
}