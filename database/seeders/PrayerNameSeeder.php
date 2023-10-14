<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrayerNameSeeder extends Seeder
{
  private static string $csvFileAbsPath = 'public/docs/prayer-names.csv';
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
        [$name, $specialName, $specialDays, $specialGenders] = $row;
        DB::table('prayer_names')
          ->insert([
            'name' => $name,
            'special_name' => $specialName ?: null,
            'special_days' => $specialDays ?: null,
            'special_genders' => $specialGenders ?: null
          ]);
      }
      $idx++;
    }

    fclose($csvFileContents);
  }
}