<?php

namespace App\Mail;

use App\Api\V1\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $details;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $details)
    {
        $this->user = $user;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.account-activation')
            ->from('example@example.com')
            ->bcc('example@example.com')
            ->subject('SiGes Quasar: Ative a sua conta !')
            ->with('details', $this->details);
    }
}
