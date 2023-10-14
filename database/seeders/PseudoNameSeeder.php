<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PseudoNameSeeder extends Seeder
{
  private static string $csvFileAbsPath = 'public/docs/pseudo-names.csv';
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
        [$name, $gender] = $row;
        DB::table('pseudo_names')
          ->insert([
            'name' => $name,
            'gender' => $gender
          ]);
      }
      $idx++;
    }

    fclose($csvFileContents);
  }
}