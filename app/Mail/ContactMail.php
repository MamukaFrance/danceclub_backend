<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactMail extends Mailable
{
    public string $name;
    public string $email;
    public string $messageContent;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->messageContent = $message;
    }

    public function build()
    {
        return $this
            ->subject('Nouveau message de contact')
            ->view('emails.contact')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'content' => $this->messageContent,
            ]);
    }
}
