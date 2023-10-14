<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PseudoNameService;
use App\Actions\User\LogoutUser;
use App\Actions\User\EditUserProfile;
use App\Actions\User\StoreUser;
use App\Actions\User\AuthenticateUser;
use App\Http\Requests\User\AuthenticateUserRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function store(StoreUserRequest $request, StoreUser $storeUser)
  {
    $user = $storeUser->execute($request->validated());

    auth()->login($user);

    return redirect('/')->with([
      'alert-type' => 'success',
      'message' => 'Congrats! You have been successfully registered.'
    ]);
  }

  public function login(PseudoNameService $pseudoNameService)
  {
    $pseudoNames = $pseudoNameService->getAll();

    return view('users.login', compact('pseudoNames'));
  }

  public function authenticate(AuthenticateUserRequest $request, AuthenticateUser $authenticateUser)
  {
    if (!$authenticateUser->execute($request)) {
      return back()->withErrors(['generic' => 'Invalid pseudo name or password'])->onlyInput('generic');
    } else {
      return redirect('/')->with([
        'alert-type' => 'success',
        'message' => 'You\'re now logged in!'
      ]);
    }
  }

  public function destroy(Request $request, LogoutUser $logoutUser)
  {
    $logoutUser->execute($request);

    return redirect('/login')->with([
      'alert-type' => 'success',
      'message' => 'Logged out successfully'
    ]);
  }

  public function showEditProfile(PseudoNameService $pseudoNameService)
  {
    $pseudoNames = $pseudoNameService->getAvailableWithOwn(auth()->user());

    return view('users.edit-profile', compact('pseudoNames'));
  }

  public function editProfile(EditProfileRequest $request, EditUserProfile $editUserProfile)
  {
    $editUserProfile->execute(auth()->id(), $request->validated());

    return back()->with([
      'alert-type' => 'success',
      'message' => 'Profile updated successfully'
    ]);
  }
}