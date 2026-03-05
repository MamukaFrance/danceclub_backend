<?php

namespace App\Services;

use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CourseException;
use Illuminate\Database\QueryException;
use App\DTOs\CourseReservationDTO;
use App\Events\CourseReserved;
use App\Events\CourseCancelled;
use Illuminate\Support\Facades\Event;


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
    
    public function reserve(CourseReservationDTO $dto)
    {
            return DB::transaction(function () use ($dto) {

                // Verrouille la ligne du cours
                $course = Course::lockForUpdate()
                ->findOrFail($dto->courseId);

                if (!$course) {
                throw new CourseException("Cours introuvable.");
            }

                // Vérifier les places restantes
                if ($course->remaining_seats <= 0) {
                    throw new CourseException('Aucune place restante pour ce cours.');
                }

                $reservation = $this->courseRepository->reserve($dto);

                // Event
                event(new CourseReserved($reservation));

                return $reservation;

            });
    }

    public function cancel(CourseReservationDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            // Verrouille la ligne du cours
            $course = Course::where('id', $dto->courseId)
                ->lockForUpdate()
                ->first();

            if (!$course) {
                throw new CourseException("Cours introuvable.");
            }

            // Vérifier si l'utilisateur a une réservation
            $hasReservation = $course->reservations()
                ->where('user_id', $dto->userId)
                ->exists();

            if (! $hasReservation) {
                throw new CourseException('Vous n\'avez pas de réservation pour ce cours.');
            }

            $reservation = $this->courseRepository->cancel($dto);

            // Event
            event(new CourseCancelled($reservation));

            return $reservation;
        });
    }

}