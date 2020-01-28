<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\OrderController;

use App\Transaction;

class PaymentDuration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $trx;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $trx)
    {
        $this->trx = $trx;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cancelled = new OrderController;
        return $cancelled->auto_cancel_trx($this->trx->id);
    }
}
