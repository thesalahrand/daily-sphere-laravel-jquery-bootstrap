<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PseudoNameService
{
  public function getAll(): array
  {
    return DB::table('pseudo_names')
      ->select('id', 'name')
      ->orderBy('name', 'asc')
      ->get()
      ->toArray();
  }

  public function getAvailable(string $gender): array
  {
    return DB::table('pseudo_names')
      ->select('id', 'name')
      ->whereNotIn('id', function (Builder $query) {
        $query->select('pseudo_name_id')->from('users');
      })
      ->where('gender', $gender)
      ->orderBy('name', 'asc')
      ->get()
      ->toArray();
  }

  public function getAvailableWithOwn(User $user): array
  {
    return [
      (object) [
        'id' => $user->pseudo_name_id,
        'name' => $user->pseudoName->name
      ]
    ] + $this->getAvailable($user->pseudoName->gender);
  }
}