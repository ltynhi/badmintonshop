<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Chào mừng đến với Coza Shop!')
                    ->view('emails.welcome')
                    ->with([
                        'user' => $this->user,
                        'loginUrl' => route('login'),
                        'shopUrl' => route('list-product'),
                        'supportEmail' => config('mail.from.address', 'support@cozashop.com')
                    ]);
    }
}