<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlcTasks extends Migration
{
  public function up()
  {
    Schema::create('plc_tasks', function ($table) {
      $table->increments('id');
      $table->integer('plc_id');
      $table->string('request');
      $table->string('response')->nullable();
    });
  }

  public function down()
  {
    Schema::dropIfExists('plc_tasks');
  }
}
