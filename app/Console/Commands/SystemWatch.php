<?php

namespace App\Console\Commands;

use App\Systems\Manager;

class SystemWatch extends _Command
{
  protected $signature = 'system:watch';

  protected $description = 'run system';

  public function handle(Manager $manager)
  {
    $manager->start();
  }
}
