<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use Rememberable;

    protected $rememberCacheTag;
    protected $rememberFor;
  
    public function __construct(array $attributes = [])
    {
      parent::__construct($attributes);
      $this->rememberCacheTag = $this->getTable('categories');
      $this->rememberFor = 60*24;
    }
    
    public function subcategories(){
    	return $this->hasMany(SubCategory::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }
}
