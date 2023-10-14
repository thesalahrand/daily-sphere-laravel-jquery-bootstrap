<?php
namespace App\Actions\Trackers\Prayer;

use App\Models\PrayerTracker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetIncompleteDates
{
  public const MAX_DATES_CNT = 5;
  public const EXACT_NOT_NULL_ROWS_CNT = 10;

  public function execute(User $user)
  {
    $incompleteDates = [];

    $completeDates = DB::table('prayer_trackers')
      ->where('user_id', $user->id)
      ->whereNotNull('prayer_offering_option_id')
      ->groupBy('date')
      ->havingRaw('COUNT(*) = ' . self::EXACT_NOT_NULL_ROWS_CNT)
      ->orderBy('date', 'DESC')
      ->pluck('date')
      ->toArray();

    $subscriptionDate = Carbon::parse($user->prayer_tracker_subscription_date);
    $yesterday = Carbon::yesterday();
    $datesInRange = Carbon::parse($subscriptionDate)->range($yesterday, '1 day');

    foreach ($datesInRange as $date) {
      if (!in_array($date->format('Y-m-d'), $completeDates)) {
        $incompleteDates[] = $date;
      }
    }

    $incompleteDates = array_filter(array_reverse($incompleteDates), function ($value, $key) {
      return $key < self::MAX_DATES_CNT;
    }, ARRAY_FILTER_USE_BOTH);

    return $incompleteDates;
  }
}