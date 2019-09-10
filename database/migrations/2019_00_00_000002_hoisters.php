<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hoisters extends Migration
{
  public function up()
  {
    Schema::create('hoisters', function($table) {
      $table->increments('id');
      $table->integer('plc_id');

      $table->integer('log_interval');
      $table->integer('heartbeat_interval');

      $table->string('shuttle_address');
      $table->integer('heartbeat_address');
      $table->integer('lift_position_address');

      // state
      $table->string('shuttle');
      $table->string('lift_position');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoisters');
  }
}
