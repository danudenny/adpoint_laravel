<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Transaction;

class PaymentDuration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trx;
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
        $cancel = Transaction::where('id', $this->$trx->id)->first();
        if ($cancel !== null) {
            $cancel->status = "cancelled";
            $cancel->save();
        }
    }
}
