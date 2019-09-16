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
			'port' => 9520,
			'comment' => '测试PLC',
			'heartbeat_rate' => '2',
			'heartbeat' => 0,
			'created_at' => Carbon::now()
    ]);

    DB::table('hoisters')->insert([
      'plc_id' => 1,
      'name' => 'test_hoister',
      'heartbeat_interval' => 3,
      'shuttle_address' => '002000',
      'heartbeat_address' => '002001',
      'lift_position_address' => '002002'
    ]);

    $floors = [];
    for ($i = 0; $i < 5; $i++) {
      $floors[] = [
        'key' => $i + 1,
        'hoister_id' => 1,
        'gate1_auto_address' => '003001',
        'gate1_alarm_address' => '003002',
        'gate1_occupied_address' => '003003',
        'gate2_auto_address' => '003004',
        'gate2_occupied_address' => '003005',
        'gate2_alarm_address' => '003006',
      ];
    }

    DB::table('hoister_floors')->insert($floors);
	}
}
