<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;


class MailController extends Controller
{
    public function send(ContactRequest $request)
    {
        try {
            $data = $request->validated();
            Mail::to('test@example.com')->send(
                new ContactMail(
                    $data['name'],
                    $data['email'],
                    $data['message']
                )
            );
        } catch (Exception $e) {
            Log::error('Mail send failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors('Envoi du message impossible.');
        }

        return back()->with('success', 'Message envoyé');
    }
}
