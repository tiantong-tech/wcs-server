<?php

namespace App\Console\Commands;

use App\System\HoisterStateServer;

class WebSocket extends _Command
{
  protected $signature = 'websocket';

  protected $description = 'test command';

  public function handle(HoisterStateServer $server)
  {
    $server->start();
  }
}
