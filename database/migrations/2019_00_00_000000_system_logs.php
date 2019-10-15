<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemLogs extends Migration
{
  public function up()
  {
    Schema::create('system_logs', function (Blueprint $table) {
      $table->increments('id');
      $table->string('system');
      $table->string('type');
      $table->string('operation');
      $table->string('detail');
      $table->timestamp('created_at');
    });
  }

  public function down()
  {
    Schema::dropIfExists('system_logs');
  }
}
