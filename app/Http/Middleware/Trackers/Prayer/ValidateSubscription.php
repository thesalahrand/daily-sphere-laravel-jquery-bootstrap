<?php

namespace App\Http\Middleware\Trackers\Prayer;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSubscription
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if(is_null(auth()->user()->prayer_tracker_subscription_date)) {
      return redirect()->route('subscribe_to_prayer_tracker.show');
    }

    return $next($request);
  }
}
