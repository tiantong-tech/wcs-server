<?php

namespace App\Console\Commands;

use IRedis;
use App\Plc\PlcClient as Plc;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    $key = 'system.hoister.1.state';
    IRedis::subscribe([$key], function ($state) {
      echo $state;
      echo "\n";
    });
  }
}
