<?php

namespace App\Enums;

enum EventParticipantStatus: string
{
    case REGISTERED  = 'registered';
    case CANCELLED  = 'cancelled';
}
