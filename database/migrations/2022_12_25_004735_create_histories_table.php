<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('histories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('major_id')->constrained()->cascadeOnDelete();
      $table->foreignId('sub_id')->constrained()->cascadeOnDelete();
      $table->string('operation');
      $table->string('author');
      $table->string('title');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('histories');
  }
};
