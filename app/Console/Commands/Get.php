<?php

namespace App\Console\Commands;

use IRedis as Redis;
use App\Models\Hoister;
use Swoole\Coroutine;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    Redis::set('test', true);
    $a = [1];
    for ($i = 0; $i < 10; $i++) {
      go (function () {
        $time = random_int(0, 1000);
        $arr = [];
        for ($j = 0; $j < 10; $j++) {
          echo $j;
          Coroutine::sleep(1);
        }
      });
      go (function () {
        for ($j = 0; $j < 10; $j++) {
          echo "\nfor2 $j\n";
          Coroutine::sleep(1);
        }
      });
    }
  }
}
