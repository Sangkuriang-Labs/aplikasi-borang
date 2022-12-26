<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('subs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('standard_id')->constrained()->cascadeOnDelete();
      $table->string('title')->nullable(false);
      $table->string('number')->unique();
      $table->boolean('child')->default(false);
      $table->text('desc')->nullable(true);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('subs');
  }
};
