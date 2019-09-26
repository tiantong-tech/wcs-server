<?php

namespace App\Console\Commands;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Models\Hoister;
use App\System\HoisterStateServer;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle(HoisterStateServer $server)
  {
    $server->start();
  }
}
