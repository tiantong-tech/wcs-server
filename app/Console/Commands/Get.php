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
    for ($i = 0; $i < 10; $i++) {
      go(function () use ($i) {
        echo $i;
        Coroutine::sleep(1);
      });
    }
  }
}
