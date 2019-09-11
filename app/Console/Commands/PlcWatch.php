<?php

namespace App\Console\Commands;

use App\Plc\Client as Plc;

class PlcWatch extends _Command
{
  protected $signature = 'plc:watch';

  protected $description = 'Watching plc';

  protected $plc;

  public function handle()
  {
    $this->plc = new Plc('localhost', 9502);
    $this->plc->connect();
    $i = 0;
    $self = $this;
    // $this->plc->try(function () {

    // });
    // $this->plc->while(function () {

    // });

    while(++$i) {
      echo "Round $i\n";
      try {
        if ($i % 1 == 0) {
            $this->handleCheck();
          }
          if ($i % 3 == 0) {
            $this->handleHeartbeat($i);
          }
          echo "\n\n";
      } catch (\Exception $e) {
        $this->plc->reconnect();
      }
      sleep(1);
    }
  }

  private function handleCheck()
  {
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    $this->plc->creadD('003000');
    echo "1. 提升机状态记录完毕\n";
  }

  private function handleHeartbeat($i)
  {
    $this->plc->cwriteD('002000', $i);

    echo "2. 心跳处理完毕\n";
  }
}
