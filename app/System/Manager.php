<?php

namespace App\System;

use Swoole\Coroutine;
use Illuminate\Support\Facades\Redis;

class Manager implements ManagerContact
{
  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct(HoisterSystemAccessor $hoister)
  {
    // $pid = Redis::get('pid');
    // if ($pid) {
    //   echo "系统运行中: $pid";

    //   exit();
    // } else {
    //   Redis::set('pid', getmypid());
    // }

    $this->maxTime = 10000;
    $this->watchInterval = 5;
    $this->keepaliveInterval = 5;
    $this->hoisters = $hoister->hoisters();
  }

  public function run()
  {
    go (function () {
      $time = 0;
      while(1) {
        $this->keepalive($time);
        $time++;
        Coroutine::sleep(1);
      }
    });
    foreach ($this->hoisters as $key => $hoister) {
      go(function () use ($key, $hoister) {
        $hoister->beforeRun();
        $time = 0;
        while (1) {
          echo "提升机$key, round $time\n";
          $hoister->run($time);
          echo "任务执行完毕\n";

          Coroutine::sleep(1);
          $time++;
        }
      });
    }
  }

  public function close()
  {
    Redis::set('system.manager.close', 1);
  }

  public function keepalive($time)
  {
    if ($time % $this->keepaliveInterval == 0) {
      Redis::set('system.manager.keepalive', 1);
      Redis::expire('system.manager.keepalive', $this->keepaliveInterval + 1);
      echo "wcs 存活记录完毕\n";
    }
  }

  public function isAlive(): boolean
  {
    return Redis::get('system.manager.keepalive') ? true : false;
  }
}
