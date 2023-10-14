<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrayerOfferingOptionSeeder extends Seeder
{
  private static string $csvFileAbsPath = 'public/docs/prayer-offering-options.csv';
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
        [
          $prayerTypeId,
          $option,
          $applicableGenders,
          $points,
          $specialPoints,
          $specialGenders,
          $shortDesc
        ] = $row;

        DB::table('prayer_offering_options')
          ->insert([
            'prayer_type_id' => $prayerTypeId,
            'option' => $option,
            'applicable_genders' => $applicableGenders,
            'points' => $points,
            'special_points' => $specialPoints ?: null,
            'special_genders' => $specialGenders ?: null,
            'short_desc' => $shortDesc ?: null,
          ]);
      }
      $idx++;
    }

    fclose($csvFileContents);
  }
}