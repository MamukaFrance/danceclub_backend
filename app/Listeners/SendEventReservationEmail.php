<?php

namespace App\Listeners;

use App\Events\EventReserved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReservationConfirmed;

class SendEventReservationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventReserved $event): void
    {
        Mail::to($event->participant->user->email)
            ->send(new EventReservationConfirmed($event->participant));
    }
}
