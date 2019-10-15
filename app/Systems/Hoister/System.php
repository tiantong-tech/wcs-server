<?php

namespace App\Systems\Hoister;

use App\Models\Hoister;
use App\Laravel\EventBus;

class System
{
  public $state;

  public $entity;

  public $event;

  public $taskLoop;

  public function __construct(Hoister $entity)
  { 
    $this->entity = $entity;
    $this->event = new EventBus();
    $this->state = new SystemState($this);
    $this->taskLoop = new SystemTaskLoop($this);
    $this->taskQueue = new SystemTaskQueue($this);
  }
}
