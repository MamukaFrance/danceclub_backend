<?php

namespace App\Services;

use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Models\Course;

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

    public function getAllTeacgers(){
        return $this->courseRepository->getAllTeacgers();
    }       
}