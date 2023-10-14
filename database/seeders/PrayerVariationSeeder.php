<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrayerVariationSeeder extends Seeder
{
  private static string $csvFileAbsPath = 'public/docs/prayer-variations.csv';
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
        [$prayerNameId, $prayerTypeId, $shortDesc, $specialShortDesc] = $row;
        DB::table('prayer_variations')
          ->insert([
            'prayer_name_id' => $prayerNameId,
            'prayer_type_id' => $prayerTypeId ?: null,
            'short_desc' => $shortDesc,
            'special_short_desc' => $specialShortDesc ?: null,
          ]);
      }
      $idx++;
    }

    fclose($csvFileContents);
  }
}