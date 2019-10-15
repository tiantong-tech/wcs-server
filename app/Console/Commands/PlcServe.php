<?php

namespace App\Console\Commands;

use App\Devices\Plc\PlcServer;

class PlcServe extends _Command
{
  protected $signature = 'plc:serve';

  protected $description = 'run plc server';

  public function handle(PlcServer $server)
  {
    $server->start();
  }
}
