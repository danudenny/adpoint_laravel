<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Transaction;
use App\OrderDetail;
use Carbon\Carbon;

class AutoComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto complete if now equal to end_date';

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
            if ($t->payment_status == 1) {
                foreach ($t->orders as $key => $o) {
                    foreach ($o->orderDetails as $key => $od) {
                        if ($od->status === 3) {
                            $current_date = date('d M Y');
                            if (strtotime($current_date) >= strtotime($od->end_date)) {
                                $od->status = 4;
                                $od->save();
                                $product = Product::where('id', $od->product_id)->first();
                                $this->info($product->name.' completed');
                            }
                        }
                    }
                }
            }
        }
    }
}
