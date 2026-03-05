<?php

namespace App\Services;

use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CourseException;
use Illuminate\Database\QueryException;

class CourseService
{
    public function __construct(
        protected CourseRepositoryInterface $courseRepository
    ) {}

    public function getAllCourses(){
        return $this->courseRepository->all();
    }

    public function find(int $id): ?Course
    {
        return $this->courseRepository->find($id);
    }

    public function create(array $data): Course
    {
        $data['teacher_id'] = auth()->user()->teachers()->first()->id;
        $data['remaining_seats'] = $data['capacity'];
        $data['date'] = now()->toDateString();
        $data['start_time'] = '18:00:00';
        $data['end_time'] = '19:00:00';
        return $this->courseRepository->create($data);
    }

    public function update(Course $course, array $data): Course
    {
        return $this->courseRepository->update($course, $data);
    }

    public function delete(Course $course): bool
    {
        return $this->courseRepository->delete($course);
    }

    public function getAllTeachers(){
        return $this->courseRepository->getAllTeachers();
    } 
    
    public function reserve(int $userId, Course $course)
    {
        try {
            return DB::transaction(function () use ($userId,$course) {

                // Verrouille la ligne du cours
                $course = Course::lockForUpdate()
                ->findOrFail($course->id);

                // Vérifier les places restantes
                if ($course->remaining_seats <= 0) {
                    throw new CourseException('Aucune place restante pour ce cours.');
                }

                return $this->courseRepository->reserve($course, $userId);

            });
        }catch (QueryException $e) {
            // Contrainte unique violée
            throw new CourseException('Vous avez déjà réservé ce cours.');        }
    }

    public function cancel(Course $course, int $userId)
    {
        return DB::transaction(function () use ($course, $userId) {

            // Verrouille la ligne du cours
            $course = Course::where('id', $course->id)
                ->lockForUpdate()
                ->first();

            // Vérifier si l'utilisateur a une réservation
            $hasReservation = $course->reservations()
                ->where('user_id', $userId)
                ->exists();

            if (! $hasReservation) {
                throw new CourseException('Vous n\'avez pas de réservation pour ce cours.');
            }

            return $this->courseRepository->cancel($course, $userId);
        });
    }

}