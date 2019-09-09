<?php

namespace App\Swoole;

use Swoole\Server;

class TcpServer
{
  public $server;

  public function __construct()
  {

  }

  public function start()
  {
    $server = new Server("127.0.0.1", 9502);

    // 建立连接时输出
    $server->on('connect', function ($serv, $fd){
      echo "Client:Connect.\n";
    });
    // 接收消息时返回内容
    $server->on('receive', function ($serv, $fd, $from_id, $data) {
    echo "receive $data\n";

    $serv->send($fd, "success to $data\n");
    });
    // 连接关闭时输出
    $server->on('close', function ($serv, $fd) {
      echo "Client: Close.\n";
    });

    $server->start();
  }
}
