<?php

namespace App\Actions\User;

use App\Http\Requests\User\AuthenticateUserRequest;
use App\Models\User;

class AuthenticateUser
{
  public function execute(AuthenticateUserRequest $request): bool
  {
    if (!auth()->attempt($request->validated(), $request->remember)) {
      return false;
    } else {
      $request->session()->regenerate();
      return true;
    }
  }
}
