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
    Schema::create('prayer_variations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prayer_name_id')->constrained();
      $table->foreignId('prayer_type_id')->nullable()->constrained();
      $table->string('short_desc');
      $table->string('special_short_desc')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('prayer_variations');
  }
};
