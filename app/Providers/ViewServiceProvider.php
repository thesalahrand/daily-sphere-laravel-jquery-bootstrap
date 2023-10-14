<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
  private static $authUser;
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    view()->composer('*', function ($view) {
      if (auth()->check() && !self::$authUser) {
        [self::$authUser] = User::with('pseudoName')->where('users.id', auth()->id())->get();
      }
      $view->with(['authUser' => self::$authUser]);
    });
  }
}