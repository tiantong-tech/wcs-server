<?php

namespace App\System;

use Illuminate\Support\Facades\Redis;

class Manager implements ManagerContact
{
  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct(HoisterSystemAccessor $hoister)
  {
    $this->keepaliveInterval = 5;
    $this->watchInterval = 5;
    $this->maxTime = 10000;
    $this->hoisters = $hoister->hoisters();
  }

  public function run()
  {
    $time = 0;
    // 执行
    while(++$time) {
      echo "time: $time\n";
      foreach ($this->hoisters as $hoister) {
        $hoister->run($time);
      }
      if ($time % $this->keepaliveInterval == 0) {
        $this->keepalive();
        echo "WCS 存活更新完毕\n";
      }

      if ($time > 20000) {
        $time = 0;
      }

      sleep(1);
      echo "\n";
    }
  }

  public function keepalive()
  {
    Redis::set('system.manager.keepalive', 1);
    Redis::expire('system.manager.keepalive', $this->keepaliveInterval + 1);
  }

  public function isAlive(): boolean
  {
    return Redis::get('system.manager.keepalive') ? true : false;
  }
}
