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
			'host' => '127.0.0.1',
			'port' => '9502',
			'comment' => '测试PLC',
			'heartbeat_rate' => '2',
			'heartbeat' => 0,
			'created_at' => Carbon::now()
		]);
	}
}
