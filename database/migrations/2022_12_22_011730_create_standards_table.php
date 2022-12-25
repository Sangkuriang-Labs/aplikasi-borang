<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('standards', function (Blueprint $table) {
      $table->id();
      $table->string('title')->unique();
      $table->string('number')->unique();
      $table->string('desc');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('standards');
  }
};
