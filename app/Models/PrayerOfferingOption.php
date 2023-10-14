<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerOfferingOption extends Model
{
  use HasFactory;

  public function prayerType()
  {
    return $this->belongsTo(PrayerType::class);
  }
}
