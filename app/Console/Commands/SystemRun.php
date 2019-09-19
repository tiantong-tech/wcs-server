<?php

namespace App\Console\Commands;

use App\System\Manager;
use App\Plc\PlcConnectionException;
use App\Plc\PlcResponseException;

class SystemRun extends _Command
{
  protected $signature = 'system:run';

  protected $description = 'run system';

  public function handle(Manager $manager)
  {
    $manager->start();
  }
}
