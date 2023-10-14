<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class PrayerTrackerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $startDate = Carbon::today()->subtract(7, 'days');
    $endDate = Carbon::yesterday();

    $dates = CarbonPeriod::create($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
    $prayerVariations = DB::table('prayer_variations')->get();

    foreach (User::with('pseudoName')->get() as $user) {
      $user->prayer_tracker_subscription_date = $startDate->format('Y-m-d');
      $user->save();

      foreach ($dates as $date) {
        foreach ($prayerVariations as $prayerVariation) {
          $randPrayerOfferingOption = null;
          if ($prayerVariation->prayer_type_id) {
            $randPrayerOfferingOption = DB::table('prayer_offering_options')
              ->select('id')
              ->where([
                ['prayer_type_id', $prayerVariation->prayer_type_id],
                ['applicable_genders', 'like', '%' . $user->pseudoName->gender . '%']
              ])
              ->inRandomOrder()
              ->first();
          }

          DB::table('prayer_trackers')
            ->insert([
              'user_id' => $user->id,
              'prayer_variation_id' => $prayerVariation->id,
              'date' => $date->format('Y-m-d'),
              'rakats_cnt' => !$randPrayerOfferingOption ? rand(1, 11) : null,
              'prayer_offering_option_id' => $randPrayerOfferingOption ? $randPrayerOfferingOption->id : null
            ]);
        }
      }
    }
  }
}