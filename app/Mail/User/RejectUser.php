<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.users.user_reject')
            ->subject('Akun anda tidak disetujui');
    }
}
