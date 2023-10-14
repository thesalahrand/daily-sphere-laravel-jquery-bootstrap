<?php

namespace App\Http\Controllers\PseudoName;

use App\Http\Controllers\Controller;
use App\Services\PseudoNameService;
use App\Http\Requests\PseudoName\AvailableNamesRequest;

class PseudoNameController extends Controller
{
  public function available(AvailableNamesRequest $request, PseudoNameService $pseudoNameService)
  {
    return response()->json([
      'pseudo_names' => $pseudoNameService->getAvailable($request->validated()['gender'])
    ]);
  }
}