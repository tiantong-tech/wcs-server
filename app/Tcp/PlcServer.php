<?php

namespace App\Tcp;

use Swoole\Server;

class PlcServer
{
  public function start()
  {
    $server = new Server("127.0.0.1", 9502);
    $times = 0;
    // 建立连接时输出
    $server->on('connect', function ($serv, $fd){
      // echo "Client:Connect.\n";
    });
    // 接收消息时返回内容
    $server->on('receive', function ($serv, $fd, $from_id, $data) use (&$times) {
      $times++;
      if ($times % 1000 === 0) {
        echo $times;
        echo "\n";
      }
      $serv->send($fd, "D00000FF03FF00000C00001111");
    });
    // 连接关闭时输出
    $server->on('close', function ($serv, $fd) {
      echo "Client: Close.\n";
    });

    $server->start();
  }
}
