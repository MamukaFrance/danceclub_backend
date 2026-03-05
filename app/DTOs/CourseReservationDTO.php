<?php

namespace App\DTOs;

class CourseReservationDTO
{
    public function __construct(
        public int $userId,
        public int $courseId,
        public string $status = 'reserved',
        public ?string $reservationDate = null
    ) {}
}