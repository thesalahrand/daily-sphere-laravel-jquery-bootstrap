<?php

namespace App\Actions\User;

use Illuminate\Http\Request;

class LogoutUser
{
  public function execute(Request $request): void
  {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
  }
}
