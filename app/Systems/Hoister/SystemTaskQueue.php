<?php

namespace App\Systems\Hoister;

use App\Devices\Plc\Plc;

class SystemTaskQueue
{
  protected $plc;

  protected $entity;

  public function __construct($context)
  {
    $this->entity = $context->entity;
    $this->initPlc();
  }

  protected function initPlc()
  {
    $this->plc = new Plc(
      $this->entity->plc_host,
      $this->entity->plc_command_port
    );
  }
}
