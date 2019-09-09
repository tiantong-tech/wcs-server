<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlcConfigs extends Migration
{
	public function up()
	{
		Schema::create('plc_configs', function($table) {
			$table->increments('id');
      $table->integer('plc_id');
      $table->string('command');
      $table->string('data');
      $table->boolean('is_confirmed')->default(false);
      $table->timestamp('created_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('plc_configs');
	}
}
