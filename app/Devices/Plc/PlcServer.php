<?php

namespace App\Devices\Plc;

use Swoole\Server;

class PlcServer
{
  public function start()
  {
    $server = new Server("127.0.0.1", 8302);
    $times = 0;

    $server->on('connect', function ($serv, $fd){
      echo "connected: $fd";
    });

    $server->on('receive', function ($serv, $fd, $from_id, $data) use (&$times) {
      echo $data;
      echo "\n";
      $serv->send($fd, "D00000FF03FF00000C00001111");
    });

    $server->on('close', function ($serv, $fd) {
      echo "Client: Close.\n";
    });

    $server->start();
  }
}
