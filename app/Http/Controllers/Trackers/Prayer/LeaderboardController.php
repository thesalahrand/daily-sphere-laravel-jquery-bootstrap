<?php

namespace App\Http\Controllers\Trackers\Prayer;

use App\Http\Controllers\Controller;
use App\Actions\Trackers\Prayer\GetLeaders;


class LeaderboardController extends Controller
{
  public function index(GetLeaders $getLeaders)
  {
    $leaders = $getLeaders->execute(auth()->user());
    [$startDate, $endDate] = $getLeaders->getIntervalDates();

    return view('trackers.prayer.leaderboard', compact('leaders', 'startDate', 'endDate'));
  }
}
