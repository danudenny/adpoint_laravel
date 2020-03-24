<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BusinessSetting;

class RejectUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public  $user, 
            $email, 
            $value, 
            $subject;
    
    public function __construct($user)
    {
        $this->user = $user;
        $this->email = BusinessSetting::where('type','email_settings')->first()->value;
        $this->value = json_decode($this->email);
        foreach ($this->value->data as $key => $d) {
            if ($d->judul == "Reject User") {
                $this->subject = $d->subject;
            }
        }
    }

    public function build()
    {
        return $this->view('emails.users.user_reject')
            ->subject($this->subject);
    }
}
