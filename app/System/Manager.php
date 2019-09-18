<?php

namespace App\System;

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
    $time = 0;
    // 执行
    foreach ($this->hoisters as $hoister) {
      $hoister->beforeRun();
    }
    while(++$time) {
      echo "time: $time\n";
      foreach ($this->hoisters as $key => $hoister) {
        $hoister->run($time);
        echo "提升机$key 运行完毕\n";
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

  public function close()
  {
    Redis::set('system.manager.close', 1);
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
