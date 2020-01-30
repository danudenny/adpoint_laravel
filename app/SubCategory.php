<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class SubCategory extends Model
{

  use Rememberable;

  protected $rememberCacheTag;
  protected $rememberFor;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->rememberCacheTag = $this->getTable('sub_categories');
    $this->rememberFor = 60*24;
  }

  public function category(){
  	return $this->belongsTo(Category::class);
  }

  public function subsubcategories(){
  	return $this->hasMany(SubSubCategory::class);
  }
}
