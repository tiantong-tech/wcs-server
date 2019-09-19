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
      $table->string('name');

      $table->string('plc_host');
      $table->string('plc_port');

      $table->integer('heartbeat_interval')->default(2);
      $table->string('shuttle_address');
      $table->string('heartbeat_address');
      $table->string('lift_position_address');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoisters');
  }
}
