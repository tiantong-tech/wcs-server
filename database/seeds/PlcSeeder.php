<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlcSeeder extends Seeder
{
	public function run()
	{
		DB::table('plcs')->insert([
			'name' => 'test',
			'host' => 'localhost',
			'port' => '9503',
			'comment' => '测试PLC',
			'heartbeat_rate' => '2',
			'heartbeat' => 0,
			'created_at' => Carbon::now()
		]);
	}
}
