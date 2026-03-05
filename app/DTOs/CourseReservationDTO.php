<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Enums\CourseReservationStatus;


class CourseReservationDTO extends BaseDTO
{
    public function __construct(
        public int $userId,
        public int $courseId,
        public string $status = CourseReservationStatus::RESERVED->value,
        public ?Carbon $reservationDate = null
    ) {}

    public static function fromRequest(Request $request, Course $course): self
    {
        return new self(
            userId: $request->user()->id,
            courseId: $course->id,
            status: CourseReservationStatus::RESERVED->value,
            reservationDate: now()
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'course_id' => $this->courseId,
            'status' => $this->status,
            'reservation_date' => $this->reservationDate ?? now(),
        ];
    }
}