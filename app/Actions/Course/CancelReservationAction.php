<?php

namespace App\Actions\Course;

use App\DTOs\CourseReservationDTO;
use App\Services\CourseService;
use App\Exceptions\CourseException;

class CancelReservationAction
{
    public function __construct(private CourseService $courseService) {}

    public function execute(CourseReservationDTO $dto)
    {
        try {
            return $this->courseService->cancel($dto);
        } catch (CourseException $e) {
            throw $e;
        }
    }
}