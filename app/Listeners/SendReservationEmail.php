<?php

namespace App\Listeners;

use App\Events\CourseReserved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendReservationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CourseReserved $event)
    {
        $reservation = $event->reservation;

        Mail::to($reservation->user->email)
            ->send(new \App\Mail\ReservationConfirmed($reservation));
    }
}