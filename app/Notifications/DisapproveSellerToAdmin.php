<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DisapproveSellerToAdmin extends Notification
{
    use Queueable;
    public $product_name, $trx_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product_name, $trx_id)
    {
        $this->product_name = $product_name;
        $this->trx_id = $trx_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Media '.$this->product_name.' is rejected by the seller',
            'body' => 'Media '.$this->product_name.' is rejected by the seller',
            'url' => url('/admin/transaction/details/'.encrypt($this->trx_id))
        ];
    }
}
