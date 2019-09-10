<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Plcs extends Migration
{
	public function up()
	{
		Schema::create('plcs', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('host');
			$table->string('port');
			$table->string('comment')->default('');
			$table->integer('heartbeat')->default(0);
			$table->integer('heartbeat_rate')->default(3);
			$table->timestamp('created_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('plcs');
	}
}
