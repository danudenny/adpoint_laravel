<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(UrlGenerator $url)
  {
    Schema::defaultStringLength(191);
      if (app()->environment('production')) {
          $url::forceSchema('https');
      }
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
  }
}
