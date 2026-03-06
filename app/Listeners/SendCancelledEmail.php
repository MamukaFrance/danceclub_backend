<?php

namespace App\Listeners;

use App\Events\CourseCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancelled;


class SendCancelledEmail
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
    public function handle(CourseCancelled $event): void
    {
        Mail::to($event->reservation->user->email)
            ->send(new ReservationCancelled($event->reservation));   
    }
}
