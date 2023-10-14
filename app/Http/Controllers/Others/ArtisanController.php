<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Artisan;

class ArtisanController extends Controller
{
  public function migrate()
  {
    Artisan::call('migrate');
  }

  public function seed()
  {
    Artisan::call('db:seed');
  }

  public function migrateAndSeed()
  {
    Artisan::call('migrate --seed');
  }

  public function storageLink()
  {
    Artisan::call('storage:link');
  }
}
