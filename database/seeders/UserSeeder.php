<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
  private static int $maxUsersCnt = 5;
  private static string $defaultPassword = 'daily-sphere';
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    while (DB::table('users')->count() != self::$maxUsersCnt) {
      $randPseudoName = DB::table('pseudo_names')->inRandomOrder()->first();
      User::firstOrCreate(
        ['pseudo_name_id' => $randPseudoName->id],
        ['password' => bcrypt(self::$defaultPassword)]
      );
    }
  }
}
