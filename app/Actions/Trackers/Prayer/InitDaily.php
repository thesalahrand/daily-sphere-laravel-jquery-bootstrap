<?php

namespace App\Actions\Trackers\Prayer;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class InitDaily
{
  public function execute(User $user, string $date): void
  {
    $prayerTrackersCntByDate = DB::table('prayer_trackers')
      ->where([
        ['user_id', $user->id],
        ['date', $date]
      ])->count();

    if ($prayerTrackersCntByDate > 0)
      return;

    $prayerVariations = DB::table('prayer_variations')->get()->toArray();
    $prayerTrackersToInsert = array_map(function ($prayerVariation) use ($user, $date) {
      return [
        'user_id' => $user->id,
        'date' => $date,
        'prayer_variation_id' => $prayerVariation->id
      ];
    }, $prayerVariations);

    DB::table('prayer_trackers')
      ->insert($prayerTrackersToInsert);
  }
}