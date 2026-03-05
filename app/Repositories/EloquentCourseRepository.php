<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Reservation;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\DTOs\CourseReservationDTO;

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

    public function reserve(CourseReservationDTO $dto)
    {
        $course = Course::findOrFail($dto->courseId);

        $reservation = Reservation::create([
            'user_id' => $dto->userId,
            'course_id' => $dto->courseId,
            'status' => $dto->status,
            'reservation_date' => $dto->reservationDate ?? now() 
        ]);
        if ($reservation) {
            $course->decrement('remaining_seats');
        }
        return $reservation;
    }

    public function cancel(CourseReservationDTO $dto)
    {
        $course = Course::findOrFail($dto->courseId);
            
         $reservation = Reservation::where('user_id', $dto->userId)
            ->where('course_id', $dto->courseId)
            ->first();
            
        if ($reservation) {
            $reservation->delete();
            $course->increment('remaining_seats');
        }
        return $reservation;
    }
}