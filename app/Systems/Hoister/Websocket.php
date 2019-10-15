<?php

namespace App\Systems\Hoister;

use IRedis as Redis;
use App\Services\Accessor;
use Swoole\Websocket\Server;

class HoisterStateServer extends Accessor
{
  protected $channels = [];

  protected $observers = [];

  protected $server;

  public function __construct()
  {
    $srv = new Server('localhost', env('WEBSOCKET_PORT'));

    $srv->on('open', function ($srv, $cli) {
      // handle connection opened
    });
    $srv->on('close', function ($srv, $fd) {
      if (!isset($this->observers[$fd])) return;

      $chn = $this->observers[$fd];
      unset($this->observers[$fd]);
      unset($this->channels[$chn][$fd]);
    });
    $srv->on('message', function ($srv, $cli) {
      $this->subscribeRedisChannel($cli->fd, $cli->data);
    });

    $this->server = $srv;
  }

  public function start()
  {
    $this->server->start();
  }

  public function subscribeRedisChannel($fd, $chn)
  {
    $this->observers[$fd] = $chn;
    if (array_key_exists($chn, $this->channels)) {
      $this->channels[$chn][$fd] = 1;
    } else {
      $this->channels[$chn] = [$fd => 1];
      Redis::subscribe($chn, function ($msg) use ($chn) {
        foreach ($this->channels[$chn] as $fd => $val) {
          $this->server->exist($fd) && $this->server->push($fd, $msg);
        }
      });
    }
  }
}
