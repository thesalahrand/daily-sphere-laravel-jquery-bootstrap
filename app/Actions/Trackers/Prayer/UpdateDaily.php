<?php

namespace App\Actions\Trackers\Prayer;

use App\Models\PrayerTracker;

class UpdateDaily
{
  public function execute($validated): void
  {
    foreach ($validated['prayer_tracker'] as $prayerVariationId => $prayerOfferingOptionId) {
      $prayerTracker = PrayerTracker
        ::where([
          ['user_id', auth()->id()],
          ['prayer_variation_id', $prayerVariationId],
          ['date', $validated['date']],
        ])
        ->firstOrFail();

      $prayerTracker->{$prayerVariationId != 11 ? 'prayer_offering_option_id' : 'rakats_cnt'} = $prayerOfferingOptionId;
      $prayerTracker->save();
    }
  }
}
