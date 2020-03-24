<?php

namespace App\Mail\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BusinessSetting;

class ShopRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public  $user, 
            $email, 
            $value, 
            $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->email = BusinessSetting::where('type','email_settings')->first()->value;
        $this->value = json_decode($this->email);
        foreach ($this->value->data as $key => $d) {
            if ($d->judul == "Shop Rejected") {
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
        return $this->view('emails.shops.shop_rejected')
            ->subject($this->subject);
    }
}
