<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrayerTypeSeeder extends Seeder
{
  private static string $csvFileAbsPath = 'public/docs/prayer-types.csv';
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $csvFileContents = fopen(base_path(self::$csvFileAbsPath), 'r');

    $idx = 0;
    while (($row = fgetcsv($csvFileContents, 555, ',')) !== false) {
      if ($idx != 0) {
        [$type] = $row;
        DB::table('prayer_types')
          ->insert([
            'type' => $type,
          ]);
      }
      $idx++;
    }

    fclose($csvFileContents);
  }
}