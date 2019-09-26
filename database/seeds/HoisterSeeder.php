<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoisterSeeder extends Seeder
{
	public function run()
	{
    for ($j = 0; $j < 10; $j++) {
      $id = DB::table('hoisters')->insertGetId([
        'plc_host' => '127.0.0.1',
        'plc_task_port' => '9502',
        'plc_command_port' => '9502',
        'name' => '测试提升机 ' . ($j + 1),
        'heartbeat_interval' => random_int(2, 5),
        'dispatch_address' => 'D002000',
        'heartbeat_address' => 'D002001',
        'lift_position_address' => 'D002002',
        'is_configured' => true,
      ]);

      $floors = [];
      for ($i = 0; $i < 10; $i++) {
        $floors[] = [
          'key' => $i + 1,
          'floor' => $i + 1,
          'hoister_id' => $id,
          'door1_auto_address' => "D0030$i" . '1',
          'door1_alarm_address' => "D0030$i" . '2',
          'door1_block_address' => "D0030$i" . '3',
          // 'door2_auto_address' => "003$i" . '04',
          // 'door2_occupied_address' => "003$i" . '05',
          // 'door2_alarm_address' => "003$i" . '06',
        ];
      }

      DB::table('hoister_floors')->insert($floors);
    }
	}
}
