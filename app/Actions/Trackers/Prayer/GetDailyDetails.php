<?php

namespace App\Actions\Trackers\Prayer;

use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class GetDailyDetails
{
  public function getPrayerNameRawSql(string $userGender, string $date): string
  {
    return 'case
      when (
        instr(prayer_names.special_genders, "' . $userGender . '") > 0
        and instr(prayer_names.special_days, date_format("' . $date . '", "%a")) > 0
      ) then prayer_names.special_name
      else prayer_names.name
    end as prayer_name';
  }

  public function getPrayerDescRawSql(string $userGender, string $date): string
  {
    return 'case
      when (
        instr(prayer_names.special_genders, "' . $userGender . '") > 0
        and instr(prayer_names.special_days, date_format("' . $date . '", "%a")) > 0
      ) then prayer_variations.special_short_desc
      else prayer_variations.short_desc
    end as prayer_desc';
  }

  public function getPrayerOfferingPointRawSql(string $userGender): string
  {
    return 'case
      when instr(prayer_offering_options.special_genders, "' . $userGender . '") > 0 then prayer_offering_options.special_points
      else prayer_offering_options.points
    end as prayer_offering_option_points';
  }

  public function execute(User $user, string $date): array
  {
    $dailyDetailsExceptOtherPrayer = DB::table('prayer_trackers')
      ->where([
        ['prayer_trackers.user_id', '=', $user->id],
        ['prayer_trackers.date', '=', $date]
      ])
      ->join('prayer_variations', 'prayer_trackers.prayer_variation_id', '=', 'prayer_variations.id')
      ->join('prayer_names', 'prayer_variations.prayer_name_id', '=', 'prayer_names.id')
      ->join('prayer_types', 'prayer_variations.prayer_type_id', '=', 'prayer_types.id')
      ->crossJoin('prayer_offering_options', function (JoinClause $join) use ($user) {
        $join->on('prayer_offering_options.prayer_type_id', '=', 'prayer_types.id')
          ->whereJsonContains('applicable_genders', $user->pseudoName->gender);
      })
      ->select(
        'prayer_variations.id as prayer_variation_id',
        'prayer_trackers.prayer_offering_option_id as chosen_prayer_offering_option_id',
        'prayer_trackers.rakats_cnt as rakats_cnt',
        DB::raw($this->getPrayerNameRawSql($user->pseudoName->gender, $date)),
        DB::raw($this->getPrayerDescRawSql($user->pseudoName->gender, $date)),
        'prayer_types.type as prayer_type',
        'prayer_offering_options.id as prayer_offering_option_id',
        'prayer_offering_options.option as prayer_offering_option',
        'prayer_offering_options.short_desc as prayer_offering_option_desc',
        DB::raw($this->getPrayerOfferingPointRawSql($user->pseudoName->gender))
      )
      ->orderBy('prayer_trackers.id', 'ASC')
      ->orderBy('prayer_offering_options.id', 'ASC')
      ->get()
      ->toArray();

    $dailyDetailsOfOtherPrayer = DB::table('prayer_trackers')
      ->where([
        ['prayer_trackers.user_id', '=', $user->id],
        ['prayer_trackers.date', '=', $date]
      ])
      ->join('prayer_variations', 'prayer_trackers.prayer_variation_id', '=', 'prayer_variations.id')
      ->join('prayer_names', 'prayer_variations.prayer_name_id', '=', 'prayer_names.id')
      ->select(
        'prayer_variations.id as prayer_variation_id',
        'prayer_trackers.rakats_cnt as rakats_cnt',
        'prayer_names.name as prayer_name',
        'prayer_variations.prayer_type_id as prayer_type',
        'prayer_variations.short_desc as prayer_desc',
      )
      ->whereNull('prayer_variations.prayer_type_id')
      ->get()
      ->toArray();

    $dailyDetails = array_merge($dailyDetailsExceptOtherPrayer, $dailyDetailsOfOtherPrayer);

    return $dailyDetails;
  }
}