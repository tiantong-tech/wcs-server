<?php

namespace App\System;

use DB;
use App\Plc\Client as Plc;
use Illuminate\Support\Facades\Redis;

class Manager implements ManagerContact
{
  protected $hoisters;

  protected $hoister;

  protected $keepaliveInterval;

  protected $maxTime;

  public function __construct()
  {
    $this->keepaliveInterval = 5;
    $this->watchInterval = 5;
    $this->maxTime = 10000;
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

  public function run()
  {
    $plc = $this->initPlc();
    $i = 0;
    // 执行
    while(++$i) {
      echo "time: $i\n";
      $plc->tryOnce(function ($plc) use ($i) {
        if ($i % 1 == 0) {
          $this->handleCheck($i, $plc);
          echo "提升机状态记录完毕\n";
        }
        if ($i % 3 == 0) {
          $this->handleHeartbeat($i, $plc);
          echo "PLC 心跳写入完毕\n";
        }
      });

      if ($i % $this->keepaliveInterval == 0) {
        $this->keepalive();
        echo "WCS 存活更新完毕\n";
      }

      if ($i > 2000000) {
        $i = 0;
      }

      // sleep(1);
      echo "\n";
    }
  }

  public function registerTask(\Closure $callback, int $interval)
  {

  }

  protected function initPlc(): Plc
  {
    $plc = new Plc('localhost', 9502);
    // $plc = new Plc('192.168.3.39', 8000);
    $plc->connect();

    return $plc;
  }

  protected function handleCheck(int $i, Plc $plc)
  {
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003003');
  }

  protected function handleHeartbeat(int $i, Plc $plc)
  {
    $plc->writewd('002200', $i, 2);
  }
}
