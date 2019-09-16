<?php

namespace App\Console\Commands;

use IRedis as Redis;
use App\Models\Hoister;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    Redis::set('test', true);

    echo getType(Redis::get('test'));
    echo "\n";
  }
}
