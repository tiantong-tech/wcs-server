<?php

namespace App\Systems;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Systems\Hoister\Manager as HoisterManager;

class Manager
{
  protected $systems = [
    'hoister' => null
  ];

  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct()
  {
    $this->handleAliveCheck();
    $this->systems['hoister'] = new HoisterManager;
  }

  public function start()
  {
    $this->maxTime = 10000;
    $this->keepaliveInterval = 1;
    $this->handleKeepalive();
  }

  public function isAlive(): bool
  {
    return Redis::get('system.manager.keepalive') ? true : false;
  }

  protected function handleAliveCheck()
  {
    if ($this->isAlive()) {
      echo "System Manager is already running\n";
      exit(0);
    }
  }

  protected function handleKeepalive()
  {
    go(function () {
      $time = 0;
      while(1) {
        if ($time % $this->keepaliveInterval == 0) {
          Redis::set('system.manager.keepalive', 1);
          Redis::expire('system.manager.keepalive', $this->keepaliveInterval + 0.1);
        }
        $time++;
        Coroutine::sleep(1);
      }
    });
  }
}
