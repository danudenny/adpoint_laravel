<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class GeneralSetting extends Model
{
    use Rememberable;

    protected $rememberCacheTag;
    protected $rememberFor;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rememberCacheTag = $this->getTable('general_settings');
        $this->rememberFor = 60*24;
    }

}
