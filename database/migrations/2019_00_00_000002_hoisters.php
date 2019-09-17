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
      $table->string('name');

      // $table->integer('log_interval');
      $table->integer('heartbeat_interval');

      $table->string('shuttle_address');
      $table->string('heartbeat_address');
      $table->string('lift_position_address');

      // state
      // $table->string('shuttle')->default(0);
      // $table->string('lift_position')->default(0);
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoisters');
  }
}
