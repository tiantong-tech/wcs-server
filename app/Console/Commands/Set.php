<?php

namespace App\Console\Commands;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Models\Hoister;

class Set extends _Command
{
  protected $signature = 'set';

  protected $description = 'test command';

  public function handle()
  {
    Redis::publish('test-channel', json_encode(['foo' => '123123']));
  }
}
