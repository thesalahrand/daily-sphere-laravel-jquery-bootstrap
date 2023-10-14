<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTracker extends Model
{
  use HasFactory;

  protected $fillable = [
    'prayer_variation_id',
    'user_id',
    'prayer_offering_option_id',
    'rakats_cnt',
    'date'
  ];

  public function prayerVariation()
  {
    return $this->belongsTo(PrayerVariation::class);
  }

  public function prayerOfferingOption()
  {
    return $this->belongsTo(PrayerOfferingOption::class);
  }
}
