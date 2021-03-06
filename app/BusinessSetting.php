<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class BusinessSetting extends Model
{
    use Rememberable;

    protected $rememberCacheTag;
    protected $rememberFor;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rememberCacheTag = $this->getTable('business_settings');
        $this->rememberFor = 60*24;
    }
}
