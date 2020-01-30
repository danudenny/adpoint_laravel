<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class Shop extends Model
{
  use Rememberable;

  protected $rememberCacheTag;
  protected $rememberFor;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->rememberCacheTag = $this->getTable('shops');
    $this->rememberFor = 60*24;
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
