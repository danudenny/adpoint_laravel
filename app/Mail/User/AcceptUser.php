<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.users.user_accept')
            ->subject('Akun anda telah disetujui');
    }
}
