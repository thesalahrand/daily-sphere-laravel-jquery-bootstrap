<?php

namespace Database\Seeders;

use Database\Seeders\PrayerNameSeeder;
use Database\Seeders\PrayerOfferingOptionSeeder;
use Database\Seeders\PrayerTypeSeeder;
use Database\Seeders\PrayerVariationSeeder;
use Database\Seeders\PseudoNameSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      PseudoNameSeeder::class,
      UserSeeder::class,
      PrayerNameSeeder::class,
      PrayerTypeSeeder::class,
      PrayerVariationSeeder::class,
      PrayerOfferingOptionSeeder::class,
      PrayerTrackerSeeder::class
    ]);
  }
}
