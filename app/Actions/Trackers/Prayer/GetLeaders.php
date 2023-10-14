<?php
namespace App\Actions\Trackers\Prayer;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetLeaders
{
  public const MAX_DAYS = 40;
  public const MAX_LEADERS_PER_PAGE = 10;
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

  public function getIntervalDates()
  {
    $startDate = Carbon::today()->subtract(self::MAX_DAYS, 'day');
    $endDate = Carbon::yesterday();

    return [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')];
  }

  public function getFardSuccessRateRawSql(string $startDate, string $endDate): string
  {
    return 'round((
      ifnull(
        sum(
          case
              when (
                prayer_offering_options.prayer_type_id = ' . self::FARD_PRAYER_ID . '
                and instr(prayer_offering_options.special_genders, pseudo_names.gender) > 0
              ) then prayer_offering_options.special_points
              when prayer_offering_options.prayer_type_id = ' . self::FARD_PRAYER_ID . ' then prayer_offering_options.points
              else 0
          end
        )
      , 0) /
      (
        case
          when pseudo_names.gender = "Male" then 5 * ' . self::MAX_PRAYER_POINTS['FARD']['MALE'] . ' * (1 + datediff("' . $endDate . '", greatest(users.prayer_tracker_subscription_date, "' . $startDate . '")))
          else 5 * ' . self::MAX_PRAYER_POINTS['FARD']['FEMALE'] . ' * (1 + datediff("' . $endDate . '", greatest(users.prayer_tracker_subscription_date, "' . $startDate . '")))
        end
      )
      * 100), 2)
    as fard_success_rate';
  }

  public function getSunnahSuccessRateRawSql(string $startDate, string $endDate): string
  {
    return 'round((
      ifnull(
        sum(
          case
            when (
              prayer_offering_options.prayer_type_id = ' . self::SUNNAH_PRAYER_ID . '
              and instr(prayer_offering_options.special_genders, pseudo_names.gender) > 0
            ) then prayer_offering_options.special_points
            when prayer_offering_options.prayer_type_id = ' . self::SUNNAH_PRAYER_ID . ' then prayer_offering_options.points
            else 0
          end
        )
      , 0) /
      (
        case
          when pseudo_names.gender = "Male" then 5 * ' . self::MAX_PRAYER_POINTS['SUNNAH']['MALE'] . ' * (1 + datediff("' . $endDate . '", greatest(users.prayer_tracker_subscription_date, "' . $startDate . '")))
          else 5 * ' . self::MAX_PRAYER_POINTS['SUNNAH']['FEMALE'] . ' * (1 + datediff("' . $endDate . '", greatest(users.prayer_tracker_subscription_date, "' . $startDate . '")))
        end
      )
      * 100), 2)
    as sunnah_success_rate';
  }

  public function execute(User $user)
  {
    [$startDate, $endDate] = $this->getIntervalDates();

    DB::statement("SET SQL_MODE=''");

    return DB::table('prayer_trackers')
      ->leftJoin('prayer_offering_options', 'prayer_trackers.prayer_offering_option_id', '=', 'prayer_offering_options.id')
      ->join('users', 'prayer_trackers.user_id', '=', 'users.id')
      ->join('pseudo_names', 'users.pseudo_name_id', '=', 'pseudo_names.id')
      ->select(
        'prayer_trackers.user_id',
        'pseudo_names.gender',
        DB::raw('(1 + datediff("' . $endDate . '", users.prayer_tracker_subscription_date)) as subscription_duration'),
        DB::raw('(1 + datediff("' . $endDate . '", greatest(users.prayer_tracker_subscription_date, "' . $startDate . '"))) as stat_duration'),
        DB::raw($this->getFardSuccessRateRawSql($startDate, $endDate)),
        DB::raw($this->getSunnahSuccessRateRawSql($startDate, $endDate)),
        DB::raw('ifnull(sum(prayer_trackers.rakats_cnt), 0) as others_rakats_count')
      )
      ->where('pseudo_names.gender', $user->pseudoName->gender)
      ->whereBetween('prayer_trackers.date', [$startDate, $endDate])
      ->groupBy('prayer_trackers.user_id')
      ->orderBy('fard_success_rate', 'DESC')
      ->orderBy('sunnah_success_rate', 'DESC')
      ->orderBy('others_rakats_count', 'DESC')
      ->orderBy('subscription_duration', 'DESC')
      ->paginate(self::MAX_LEADERS_PER_PAGE);
  }
}