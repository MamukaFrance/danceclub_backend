<?php

namespace App\Listeners;

use App\Events\EventCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReservationCancelled;


class SendEventCancelledEmail
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
    public function handle(EventCancelled $event): void
    {
        Mail::to($event->participant->user->email)
            ->send(new EventReservationCancelled($event->participant));
    }
}
