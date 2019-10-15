<?php

namespace App\Console\Commands;

use App\Systems\Manager;

class SystemRun extends _Command
{
  protected $signature = 'system:run';

  protected $description = 'run system';

  public function handle(Manager $manager)
  {
    $manager->start();
  }
}
