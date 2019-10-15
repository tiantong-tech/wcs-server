<?php

namespace App\Laravel;

class Event
{
  protected $id = 1;

  protected $callbacks = [];

  protected $onetimeCallbacks = [];

  public function emit(...$params)
  {
    foreach ($this->callbacks as $callback) {
      call_user_func($callback, ...$params);
    }
    foreach ($this->onetimeCallbacks as $id => $callback) {
      call_user_func($callback, ...$params);
      $this->cancel($id);
    }
  }

  public function on(callable $callback)
  {
    $id = ++$this->id;
    $this->callbacks[$id] = $callback;

    return $this->cancelable($id);
  }

  public function once(callable $callback)
  {
    $id = ++$this->id;
    $this->onetimeCallbacks[$id] = $callback;

    return $this->cancelable($id);
  }

  protected function cancel($id)
  {
    unset($this->callbacks[$id]);
    unset($this->onetimeCallbacks[$id]);
  }

  protected function cancelable($id)
  {
    return function () use ($id) {
      $this->cancel($id);
    };
  }
}
