<?php
namespace App\Actions\Trackers\Prayer;

use Carbon\Carbon;

class GetHistoricYearsMonths
{
  public function execute(): array
  {
    $startDate = Carbon::parse(auth()->user()->prayer_tracker_subscription_date);
    $yesterdayDate = Carbon::yesterday();

    $years = array_map(function($year){
      return (string) $year;
    }, range($startDate->format('Y'), $yesterdayDate->format('Y')));

    $yearsWithMonthNo = array_map(function($year) use($startDate, $yesterdayDate){
      $result = ['year' => $year, 'minMonthNo' => '1', 'maxMonthNo' => '12'];

      if ($year === $startDate->format('Y')) {
        $result['minMonthNo'] = $startDate->format('n');
      } if($year === $yesterdayDate->format('Y')) {
        $result['maxMonthNo'] = $yesterdayDate->format('n');
      }

      return $result;
    }, $years);

    return $yearsWithMonthNo;
  }
}
