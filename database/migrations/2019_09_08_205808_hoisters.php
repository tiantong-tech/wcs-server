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
      $table->string('shuttle');
      $table->integer('heartbeat');
      $table->integer('heartbeat_address');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoisters');
  }
}
