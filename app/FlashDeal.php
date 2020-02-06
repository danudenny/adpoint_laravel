<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class FlashDeal extends Model
{
    use Rememberable;

    protected $rememberCacheTag;
    protected $rememberFor;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rememberCacheTag = $this->getTable('flash_deals');
        $this->rememberFor = 60*24;
    }

    public function flash_deal_products()
    {
        return $this->hasMany(FlashDealProduct::class);
    }
}
