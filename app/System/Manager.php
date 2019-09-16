<?php

namespace App\System;

use DB;
use App\Plc\Client as Plc;

class Manager
{
  protected $hoisters;

  protected $hoister;

  public function run()
  {
    while (1) {
      $this->handle();
      sleep(4);
    }
  }

  public function keepalive()
  {
    Redis::set('system.manager.keepalive', true);
    Redis::expire('system.manager.keepalive', 5);
  }

  public function isAlive()
  {
    return Redis::get('system.manager.keepalive') ? true : false;
  }

  public function handle()
  {
    $plc = new Plc('localhost', 9502);
    $plc->connect();
    $i = 0;
    while(++$i) {
      echo "Round $i\n";
      $plc->try(function ($plc) use ($i) {
        if ($i % 1 == 0) {
          $this->handleCheck($plc);
        }
        if ($i % 3 == 0) {
          $this->handleHeartbeat($plc, $i);
        }
        echo "\n\n";
      });
      sleep(1);
    }
  }

  protected function handleCheck(Plc $plc)
  {
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('003000');
    $plc->readwd('3003');
    echo "1. 提升机状态记录完毕\n";
  }

  protected function handleHeartbeat(Plc $plc, int $i)
  {
    $plc->writewd('002000', $i);

    echo "2. 心跳处理完毕\n";
  }
}
