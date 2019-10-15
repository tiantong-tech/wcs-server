<?php

namespace App\Systems\Hoister;

use Swoole\Coroutine;

class SystemState
{
  protected $redisKey;

  protected $event;

  protected $data;

  public function __construct(System $context)
  {
    $id = $context->entity->id;
    $this->context = $context;
    $this->event = $context->event;
    $this->redisKey = "system.hoister.$id";
  }

  public function setData($data)
  {
    $this->data = $data;
    $this->dispatchTask("test");
  }

  public function dispatchTask($code)
  {
    $handler = function () {

    };

    $this->event->once('started', $handler);
  }

  protected function taskLoop(): SystemTaskLoop
  {
    return $this->context->taskLoop;
  }

  protected function taskQueue(): SystemTaskQueue
  {
    return $this->context->taskQueue;
  }
}
