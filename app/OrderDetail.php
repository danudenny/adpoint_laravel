<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class OrderDetail extends Model
{
    use Rememberable;

    protected $rememberCacheTag;
    protected $rememberFor;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rememberCacheTag = $this->getTable('order_details');
        $this->rememberFor = 60*24;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBookingsInRange($from,$to){

        $query = OrderDetail::select('products.*', 'order_details.id as ord_id', 'order_details.*', 'orders.*')
            -> join('products', 'products.id', '=', 'order_details.product_id')
            -> join('orders', 'orders.id', '=', 'order_details.order_id')
            -> where('order_details.status', 3)
            -> where('start_date','<=',$to)->where('end_date','>=',$from)->take(50)
            -> get();
        return $query;

    }
}
