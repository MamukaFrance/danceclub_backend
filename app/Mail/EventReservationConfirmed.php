<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EventParticipant;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;


class EventReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public EventParticipant $participant;

    /**
     * Create a new message instance.
     */
    public function __construct(EventParticipant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre event réservation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_reservation_confirmed',
            with: [
                'participant' => $this->participant,
                'event' => $this->participant->event,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.event_ticket', [
        'participant' => $this->participant,
        'event' => $this->participant->event,
        ]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'ticket-evenement.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
