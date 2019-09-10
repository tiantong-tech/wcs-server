<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoisterLogs extends Migration
{
	public function up()
	{
		Schema::create('hoister_logs', function ($table) {
			$table->increments('id');
			$table->integer('hoister_id');
			$table->string('type');
			$table->string('data');
			$table->timestamp('created_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('hoister_logs');
	}
}
