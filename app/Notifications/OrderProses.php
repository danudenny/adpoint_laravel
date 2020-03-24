<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderProses extends Notification
{
    use Queueable;
    public $name, $trx_id, $trx_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $id, $code)
    {
        $this->name = $name;
        $this->trx_id = $id;
        $this->trx_code = $code;
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
            'title' => 'New transactions '.$this->trx_code.' from '. $this->name,
            'body' => 'New transactions '.$this->trx_code.' from '. $this->name,
            'url' => url('/admin/transaction/details/'.encrypt($this->trx_id))
        ];
    }
}
