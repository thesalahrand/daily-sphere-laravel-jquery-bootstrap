<?php
namespace App\Actions\Trackers\Prayer;

use App\Models\PrayerTracker;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class GetPerMonthStat
{
  public const FARD_PRAYER_ID = 1;
  public const SUNNAH_PRAYER_ID = 2;
  public const TOTAL_PRAYER_TIMES = 5;
  public const MAX_PRAYER_POINTS = [
    'FARD' => [
      'MALE' => 1200,
      'FEMALE' => 1000,
    ],
    'SUNNAH' => [
      'MALE' => 10,
      'FEMALE' => 10,
    ]
  ];

  public function getAllDays(string $year, string $monthName): array
  {
    $startDate = Carbon::parse('first day of ' . $monthName . ' ' . $year);
    $endDate = Carbon::parse('last day of ' . $monthName . ' ' . $year);

    $subscriptionDate = Carbon::parse(auth()->user()->prayer_tracker_subscription_date);
    $yesterdayDate = Carbon::yesterday();

    $actualStartDate = max($startDate, $subscriptionDate);
    $actualEndDate = min($endDate, $yesterdayDate);

    return array_map(function ($date) {
      return $date->format('Y-m-d');
    }, CarbonPeriod::create($actualStartDate->format('Y-m-d'), $actualEndDate->format('Y-m-d'))->toArray());
  }

  public function getExistingDaysStat(string $year, string $monthName): array
  {
    return DB::table('prayer_trackers')
      ->leftJoin('prayer_offering_options', 'prayer_trackers.prayer_offering_option_id', '=', 'prayer_offering_options.id')
      ->select(
        DB::raw('round((ifnull(sum(case when prayer_offering_options.prayer_type_id = ' . self::FARD_PRAYER_ID . ' and instr(prayer_offering_options.special_genders, \'' . auth()->user()->pseudoName->gender . '\') > 0 then prayer_offering_options.special_points when prayer_offering_options.prayer_type_id = ' . self::FARD_PRAYER_ID . ' then prayer_offering_options.points else 0 end), 0) / (5 * ' . self::MAX_PRAYER_POINTS['FARD'][strtoupper(auth()->user()->pseudoName->gender)] . ') * 100), 2) as fard_success_rate'),
        DB::raw('round((ifnull(sum(case when prayer_offering_options.prayer_type_id = ' . self::SUNNAH_PRAYER_ID . ' and instr(prayer_offering_options.special_genders, \'' . auth()->user()->pseudoName->gender . '\') > 0 then prayer_offering_options.special_points when prayer_offering_options.prayer_type_id = ' . self::SUNNAH_PRAYER_ID . ' then prayer_offering_options.points else 0 end), 0) / (5 * ' . self::MAX_PRAYER_POINTS['SUNNAH'][strtoupper(auth()->user()->pseudoName->gender)] . ') * 100), 2) as sunnah_success_rate'),
        DB::raw('ifnull(sum(prayer_trackers.rakats_cnt), 0) as others_rakats_count'),
        'prayer_trackers.date'
      )
      ->where('prayer_trackers.user_id', auth()->id())
      ->where(DB::raw('DATE_FORMAT(prayer_trackers.date, \'%Y\')'), $year)
      ->where(DB::raw('DATE_FORMAT(prayer_trackers.date, \'%b\')'), $monthName)
      ->groupBy('prayer_trackers.date')
      ->orderBy('prayer_trackers.date', 'ASC')
      ->get()
      ->toArray();
  }

  public function getAllDaysStat(array $allDays, array $existingDaysStat): array
  {
    $existingDaysIdx = 0;
    $allDaysStat = [];

    foreach ($allDays as $idx => $day) {
      if (isset($existingDaysStat[$existingDaysIdx]) && $day == $existingDaysStat[$existingDaysIdx]->date) {
        $allDaysStat[] = $existingDaysStat[$existingDaysIdx];
        $existingDaysIdx++;
      } else {
        $allDaysStat[] = [
          'fard_success_rate' => '0',
          'sunnah_success_rate' => '0',
          'others_rakats_count' => '0',
          'date' => $day
        ];
      }

      $allDaysStat[$idx]->date = Carbon::parse($allDaysStat[$idx]->date)->format('jS M');
    }

    return $allDaysStat;
  }

  public function execute(string $year, string $monthName)
  {
    $existingDaysStat = $this->getExistingDaysStat($year, $monthName);
    $allDays = $this->getAllDays($year, $monthName);
    $allDaysStat = $this->getAllDaysStat($allDays, $existingDaysStat);

    return $allDaysStat;
  }
}