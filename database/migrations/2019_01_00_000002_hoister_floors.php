<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoisterFloors extends Migration
{
  public function up()
  {
    Schema::create('hoister_floors', function ($table) {
      $table->increments('id');
      $table->integer('hoister_id');
      $table->integer('key')->default(0);
      $table->string('floor')->default('1');
      $table->string('door1_auto_address')->default('0');
      $table->string('door1_alarm_address')->default('0');
      $table->string('door1_block_address')->default('0');
      $table->string('door2_auto_address')->default('0');
      $table->string('door2_block_address')->default('0');
      $table->string('door2_alarm_address')->default('0');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoister_floors');
  }
}
