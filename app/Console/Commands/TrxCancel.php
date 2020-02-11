<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Transaction;
use App\OrderDetail;
use Carbon\Carbon;

class TrxCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trx:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto cancel transction if expire date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $trx = Transaction::all();
        foreach ($trx as $key => $t) {
            $expire = Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24);
            if (strtotime($t->status) < strtotime($expire) && $t->payment_status === 0 && $t->status === "confirmed") {
                $t->status = "cancelled";
                $this->info($t->code.' cancelled');
                if ($t->save()) {
                    foreach ($t->orders as $key => $o) {
                        foreach ($o->orderDetails as $key => $od) {
                            $item = OrderDetail::where('id', $od->id)->first();
                            $item->status = 2;
                            $item->save();
                        }
                    }
                }
            }
        }
    }
}
