<?php

namespace App\Repositories\Contracts;

use App\Models\Course;

interface CourseRepositoryInterface
{
    public function all();

    public function find(int $id): ?Course;

    public function create(array $data): Course;

    public function update(Course $course, array $data): Course;

    public function delete(Course $course): bool;

    public function getAllTeachers();

    public function reserve(Course $course, int $userId);

    public function cancel(Course $course, int $userId);

    // public function reserve(CourseReservationDTO $dto): void;

    // public function cancel(CourseReservationDTO $dto): void;
}
