<?php

namespace App\Enums;

enum CourseReservationStatus: string
{
    case RESERVED = 'reserved';
    case CANCELLED = 'cancelled';
}