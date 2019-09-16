<?php

namespace App\Console\Commands;

use App\System\Manager;
use App\Plc\PlcConnectionException;
use App\Plc\PlcResponseException;

class PlcWatch extends _Command
{
  protected $signature = 'plc:watch';

  protected $description = 'Watching plc';

  public function handle(Manager $manager)
  {
    $manager->run();
  }
}
