<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
	public function up()
	{
		Schema::create('series', function (Blueprint $table) {
			$table->string('name')->primary();
			$table->bigInteger('begin')->default(0);
			$table->bigInteger('end')->default(9999999);
			$table->bigInteger('value')->default(0);
		});
	}

	public function down()
	{
		Schema::dropIfExists('series');
	}
}
