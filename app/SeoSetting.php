<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class SeoSetting extends Model
{
  use Rememberable;

  protected $rememberCacheTag;
  protected $rememberFor;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->rememberCacheTag = $this->getTable('seo_settings');
    $this->rememberFor = 60*24;
  }
}
