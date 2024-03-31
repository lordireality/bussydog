<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $email;
    public $firstname;
    public $verificationToken;

    public function __construct($firstname, $verificationToken, $email)
    {
        $this->firstname = $firstname;
        $this->verificationToken = $verificationToken;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('templates.mails.registration')->subject('Подтверждение регистрации '.config('app.name'));
    }
}
