<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerVariation extends Model
{
  use HasFactory;

  public function prayerName()
  {
    return $this->belongsTo(PrayerName::class);
  }

  public function prayerType()
  {
    return $this->belongsTo(PrayerType::class);
  }
}
