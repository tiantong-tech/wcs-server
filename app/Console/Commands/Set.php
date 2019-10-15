<?php

namespace App\Console\Commands;

use App\Devices\Plc\Plc;

class Set extends _Command
{
  protected $signature = 'set';

  protected $description = 'test command';

  public function handle()
  {
    $plc = new Plc('192.168.3.39', '8000');
    $plc->connect();
    echo $plc->read('002000');
    $plc->writewd('002201', 21);
    echo $plc->read('002000');
  }
}
