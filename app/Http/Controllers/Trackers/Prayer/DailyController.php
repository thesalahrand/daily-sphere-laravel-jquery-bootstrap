<?php

namespace App\Http\Controllers\Trackers\Prayer;

use App\Actions\Trackers\Prayer\GetIncompleteDates;
use App\Actions\Trackers\Prayer\GetDailyDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trackers\Prayer\ShowDailyRequest;
use App\Http\Requests\Trackers\Prayer\UpdateDailyRequest;
use App\Actions\Trackers\Prayer\InitDaily;
use App\Actions\Trackers\Prayer\UpdateDaily;

class DailyController extends Controller
{
  public function show(ShowDailyRequest $request, InitDaily $initDaily, GetDailyDetails $getDailyDetails, GetIncompleteDates $getIncompleteDates)
  {
    $initDaily->execute(auth()->user(), request('date'));
    $dailyDetails = $getDailyDetails->execute(auth()->user(), request('date'));
    $incompleteDates = $getIncompleteDates->execute(auth()->user());

    return view('trackers.prayer.daily', compact('dailyDetails', 'incompleteDates'));
  }

  public function update(UpdateDailyRequest $request, UpdateDaily $updateDaily)
  {
    $updateDaily->execute($request->validated());

    return back()->with([
      'alert-type' => 'success',
      'message' => 'Details saved successfully!'
    ]);
  }
}