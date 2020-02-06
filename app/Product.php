<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
  use Rememberable;

  protected $rememberCacheTag;
  protected $rememberFor;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->rememberCacheTag = $this->getTable('products');
    $this->rememberFor = 60*24;
  }

  public function category(){
  	return $this->belongsTo(Category::class);
  }

  public function subcategory(){
  	return $this->belongsTo(SubCategory::class);
  }

  public function subsubcategory(){
  	return $this->belongsTo(SubSubCategory::class);
  }

  public function brand(){
  	return $this->belongsTo(Brand::class);
  }

  public function user(){
  	return $this->belongsTo(User::class);
  }

  public function orderDetails(){
    return $this->hasMany(OrderDetail::class);
  }

  public function reviews(){
    return $this->hasMany(Review::class)->where('status', 1);
  }
}
