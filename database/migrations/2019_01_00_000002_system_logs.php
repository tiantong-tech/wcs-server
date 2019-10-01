<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemLogs extends Migration
{
  public function up()
  {
    Schema::create('system_logs', function ($table) {
      $table->increments('id');
    });
  }

  public function down()
  {
    Schema::dropIfExists('system_logs');
  }
}
