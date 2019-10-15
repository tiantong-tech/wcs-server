<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoisterScanners extends Migration
{
  public function up()
  {
    Schema::create('hoister_scanners', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('hoister_id');
      $table->integer('key')->default(0);
      $table->string('name');

      $table->string('data_address')->default('D002901');
      $table->integer('data_length')->default(4);

      $table->unique(['hoister_id', 'key']);
      $table->unique(['hoister_id', 'data_address']);
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoister_scanners');
  }
}
