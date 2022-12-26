<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('contents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('sub_id')->constrained()->cascadeOnDelete();
      $table->foreignId('major_id')->constrained()->cascadeOnDelete();
      $table->boolean('approved')->default(false);
      $table->boolean('graded')->default(false);
      $table->float('grade')->nullable();
      $table->string('file')->nullable(false);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('contents');
  }
};
