<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Watson\Rememberable\Rememberable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements JWTSubject
{
  use Notifiable, HasPushSubscriptions, Rememberable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  protected $rememberCacheTag;
  protected $rememberFor;

  public function __construct(array $attributes = [])
  {
      parent::__construct($attributes);
      $this->rememberCacheTag = $this->getTable('users');
      $this->rememberFor = 60*24;
  }

  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function customer()
  {
    return $this->hasOne(Customer::class);
  }

  public function seller()
  {
    return $this->hasOne(Seller::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function shop()
  {
    return $this->hasOne(Shop::class);
  }

  public function staff()
  {
    return $this->hasOne(Staff::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function transaction()
  {
    return $this->hasMany(Transaction::class);
  }

  public function wallets()
  {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
  }

  public function getJWTIdentifier()
  {
      return $this->getKey();
  }
  
  public function getJWTCustomClaims()
  {
      return [
        'id'        => $this->id,
        'email'     => $this->email,
        'password'  => $this->password,
      ];
  }
}
