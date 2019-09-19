<?php

namespace App\System;

use Swoole\Coroutine;
use Illuminate\Support\Facades\Redis;

class Manager implements ManagerContact
{
  protected $hoisters;

  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct()
  {
  }

  // once start never stop
  public function start()
  {
    $hoister = new HoisterSystemAccessor();
    $this->hoisters = $hoister->hoisters();
    $this->maxTime = 10000;
    $this->watchInterval = 5;
    $this->keepaliveInterval = 1;
    $this->handleKeepalive();
    $this->autorun();
  }

  protected function autorun()
  {
    foreach ($this->hoisters as $hoister) {
      $hoister->init();
      $hoister->run();
    }
  }

  protected function handleKeepalive()
  {
    go(function () {
      $time = 0;
      while(1) {
        if ($time % $this->keepaliveInterval == 0) {
          Redis::set('system.manager.keepalive', 1);
          Redis::expire('system.manager.keepalive', $this->keepaliveInterval + 1);
          // echo "wcs 存活记录完毕\n";
        }
        $time++;
        Coroutine::sleep(1);
      }
    });
  }

  public function isAlive(): boolean
  {
    return Redis::get('system.manager.keepalive') ? true : false;
  }
}
