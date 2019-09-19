<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoisterSeeder extends Seeder
{
	public function run()
	{
    for ($j = 0; $j < 10; $j++) {
      $id = DB::table('hoisters')->insertGetId([
        'plc_host' => '127.0.0.1',
        'plc_port' => 9502,
        'name' => 'test_hoister',
        'heartbeat_interval' => random_int(2, 5),
        'shuttle_address' => '002000',
        'heartbeat_address' => '002001',
        'lift_position_address' => '002002'
      ]);

      $floors = [];
      for ($i = 0; $i < 10; $i++) {
        $floors[] = [
          'key' => $i + 1,
          'hoister_id' => $id,
          'gate1_auto_address' => "003$i" . '01',
          'gate1_alarm_address' => "003$i" . '02',
          'gate1_occupied_address' => "003$i" . '03',
          // 'gate2_auto_address' => "003$i" . '04',
          // 'gate2_occupied_address' => "003$i" . '05',
          // 'gate2_alarm_address' => "003$i" . '06',
        ];
      }

      DB::table('hoister_floors')->insert($floors);
    }
	}
}
