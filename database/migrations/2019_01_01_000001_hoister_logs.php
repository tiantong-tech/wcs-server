<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoisterLogs extends Migration
{
  public function up()
  {
    Schema::create('hoister_logs', function(Blueprint $table) {
      $table->increments('id');
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoister_logs');
  }
}
