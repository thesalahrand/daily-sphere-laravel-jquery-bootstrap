<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('prayer_offering_options', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prayer_type_id')->constrained();
      $table->string('option');
      $table->json('applicable_genders');
      $table->bigInteger('points')->nullable();
      $table->bigInteger('special_points')->nullable();
      $table->json('special_genders')->nullable();
      $table->string('short_desc');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('prayer_offering_options');
  }
};
