<?php

namespace App\Console\Commands;

use IRedis as Redis;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    Redis::set('test', 100);

    echo Redis::get('test');

    echo "\n";
  }
}
