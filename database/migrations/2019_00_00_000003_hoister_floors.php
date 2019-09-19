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
      $table->integer('key');
      $table->string('gate1_auto_address')->default('');
      $table->string('gate1_alarm_address')->default('');
      $table->string('gate1_occupied_address')->default('');
      $table->string('gate2_auto_address')->default('');
      $table->string('gate2_occupied_address')->default('');
      $table->string('gate2_alarm_address')->default('');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoister_floors');
  }
}
