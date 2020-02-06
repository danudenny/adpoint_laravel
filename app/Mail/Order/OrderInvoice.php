<?php

namespace App\Mail\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderInvoice extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $trx;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trx)
    {
        $this->trx = $trx;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.order_invoice')
            ->subject('Silahkan lakukan pembayaran !.'. $this->trx->code);
    }
}
