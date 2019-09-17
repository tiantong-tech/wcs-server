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
      $table->integer('gate1_auto_address')->default(0);
      $table->integer('gate1_alarm_address')->default(0);
      $table->integer('gate1_occupied_address')->default(0);
      $table->integer('gate2_auto_address')->default(-1);
      $table->integer('gate2_occupied_address')->default(-1);
      $table->integer('gate2_alarm_address')->default(-1);

      // state
      // $table->integer('gate1_auto')->default(0);
      // $table->integer('gate1_alarm')->default(0);
      // $table->integer('gate1_occupied')->default(0);
      // $table->integer('gate2_auto')->default(-1);
      // $table->integer('gate2_alarm')->default(-1);
      // $table->integer('gate2_occupied')->default(-1);
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoister_floors');
  }
}
