<?php

namespace App\System;

use DB;
use App\Plc\Client as Plc;

class Manager
{
  protected $hoister;

  public function __construct()
  {

  }

  public function run()
  {
    $this->handle();
  }

  public function record()
  {

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

  public function status()
  {

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
