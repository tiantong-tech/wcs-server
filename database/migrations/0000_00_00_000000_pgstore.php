<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PgStore extends Migration
{
	public function up()
	{
		Schema::create('pgstore', function (Blueprint $table) {
			$table->string('key')->primary();
			$table->jsonb('value');
		});
	}

	public function down()
	{
		Schema::drop('pgstore');
	}
}
