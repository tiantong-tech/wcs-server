<?php

namespace App\System;

use Swoole\Coroutine;
use Illuminate\Support\Facades\Redis;

class Manager
{
  protected $hoisters;

  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct()
  {
  }

  // 初始化时应该直接使用 Model
  // 添加和删除设备时，需要用 id
  public function start()
  {
    $hoister = new HoisterSystemAccessor();
    $this->hoisters = $hoister->hoisters();
    $this->maxTime = 10000;
    $this->watchInterval = 5;
    $this->keepaliveInterval = 1;
    $this->handleKeepalive();
  }

  // 增加设备移除方法

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
