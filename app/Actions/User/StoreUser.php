<?php

namespace App\Actions\User;

use App\Models\User;

class StoreUser
{
  public function execute(array $validated): User
  {
    return User::
      create([
        'pseudo_name_id' => $validated['pseudo_name_id'],
        'password' => bcrypt($validated['password'])
      ]);
  }
}