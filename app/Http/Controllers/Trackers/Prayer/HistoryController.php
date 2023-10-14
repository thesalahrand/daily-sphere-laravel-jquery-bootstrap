<?php

namespace App\Http\Controllers\Trackers\Prayer;

use App\Actions\Trackers\Prayer\GetPerMonthStat;
use App\Http\Controllers\Controller;
use App\Actions\Trackers\Prayer\GetHistoricYearsMonths;
use App\Http\Requests\Trackers\Prayer\ShowHistoryRequest;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
  public function index(ShowHistoryRequest $request, GetHistoricYearsMonths $getHistoricYearsMonths, GetPerMonthStat $getPerMonthStat)
  {
    $yearsWithMonthNo = $getHistoricYearsMonths->execute();
    $perMonthStat = $getPerMonthStat->execute(request('year'), request('month'));

    return view('trackers.prayer.history', compact('yearsWithMonthNo', 'perMonthStat'));
  }
}
