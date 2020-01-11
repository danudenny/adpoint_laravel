<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function transaction()
    {
        return $this->hashMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
