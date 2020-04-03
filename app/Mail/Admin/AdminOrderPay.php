<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BusinessSetting;


class AdminOrderPay extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public  $user,
            $email, 
            $value,
            $buyer_name,
            $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $name)
    {
        $this->user = $user;
        $this->buyer_name = $name;
        $this->email = BusinessSetting::where('type','email_settings')->first()->value;
        $this->value = json_decode($this->email);
        foreach ($this->value->data as $key => $d) {
            if ($d->judul == "Admin Order Pay") {
                $this->subject = $d->subject;
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin.admin_order_pay')
            ->subject($this->subject.$this->buyer_name);
    }
}
