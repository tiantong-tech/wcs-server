<?php

namespace App\Console\Commands;

use App\Services\Plc;

class PlcWatch extends _Command
{
  protected $signature = 'plc:watch';

  protected $plc;

  protected $description = 'Watching plc';

  public function __construct()
  {
    $this->plc = new Plc;
    parent::__construct();
  }

  public function handle()
  {
    $plc = $this->plc;
    $i = 0;
    while (++$i) {
      echo "round $i \n";

      if ($i % 1 == 0) {
        $this->handleCheck();
      }

      if ($i % 3 == 0) {
        $this->handleHeartbeat();
      }

      sleep(1);
      echo "\n\n";
    }
  }

  private function handleCheck()
  {
    $this->plc->read('D3000');
    $this->plc->recordHeartbeat(1);
    echo "1. 提升机状态记录完毕\n";
  }

  private function handleHeartbeat()
  {
    $this->plc->write('D2001', 2000);

    echo "2. 心跳处理完毕\n";
  }
}
