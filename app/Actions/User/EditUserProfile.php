<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class EditUserProfile
{
  public function execute(string $userId, array $validated): void
  {
    $user = User::find($userId);

    if ($validated['pseudo_name_id']) {
      $user->pseudo_name_id = $validated['pseudo_name_id'];
    }
    if ($validated['password']) {
      $user->password = bcrypt($validated['password']);
    }

    if (isset($validated['profile_pic'])) {
      if ($user->profile_pic) {
        Storage::disk('public')->delete($user->profile_pic);
      }
      $user->profile_pic = $validated['profile_pic']->store('users', 'public');
    }

    $user->save();
  }
}