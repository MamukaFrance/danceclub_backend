<?php

namespace App\Repositories\Contracts;

use App\Models\Course;
use App\DTOs\CourseReservationDTO;

interface CourseRepositoryInterface
{
    public function all();

    public function find(int $id): ?Course;

    public function create(array $data): Course;

    public function update(Course $course, array $data): Course;

    public function delete(Course $course): bool;

    public function getAllTeachers();

    public function reserve(CourseReservationDTO $dto);

    public function cancel(CourseReservationDTO $dto);
}
