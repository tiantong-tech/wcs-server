<?php

namespace App\Console\Commands;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Models\Hoister;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    // Redis::subscribe(['test-channel'], function ($message) {
    //   echo $message;
    // });
    $data = [
      'heartbeat' => 0,
      'lift_position' => 0,
      'floors' => [
        [
          'gate1_auto_address' => 0,
          'gate1_alarm_address' => 0,
          'gate1_occupied_address' => 0
        ],
        [
          'gate1_auto_address' => 0,
          'gate1_alarm_address' => 0,
          'gate1_occupied_address' => 0
        ],
      ]
    ];

    Redis::set('user', json_encode($data));

    $user = Redis::hgetall('user');
    dd ($user);
  }
}
