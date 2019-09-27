<?php

namespace App\Console\Commands;

use App\Plc\PlcClient as Plc;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    $plc = new Plc('192.168.3.39', '8001');
    $plc->connect();
    while (1) {
      $value = $plc->read('002000');
    }
  }
}
