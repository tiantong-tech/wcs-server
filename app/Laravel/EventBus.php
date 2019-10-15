<?php

namespace App\Laravel;

class EventBus
{
  protected $id = 0;

  protected $events = [];

  protected $callbacks = [];

  protected $onetimeCallbacks = [];

  public function emit($event, ...$params)
  {
    if (!$this->isset($event)) return;
    foreach ($this->callbacks[$event] as $callback) {
      call_user_func($callback, ...$params);
    }
    foreach ($this->onetimeCallbacks[$event] as $id => $callback) {
      call_user_func($callback, ...$params);
      $this->cancel($event, $id);
    }
  }

  public function on($event, $callback)
  {
    if (!$this->isset($event)) {
      $this->addEvent($event);
    }
    $id = ++$this->id;
    $this->callbacks[$event][$id] = $callback;

    return $this->cancelable($event, $id);
  }

  public function once($event, $callback) {
    if (!$this->isset($event)) {
      $this->addEvent($event);
    }
    $id = ++$this->id;
    $this->onetimeCallbacks[$event][$id] = $callback;

    return $this->cancelable($event, $id);
  }

  protected function addEvent($event)
  {
    $this->events[$event] = true;
    $this->callbacks[$event] = [];
    $this->onetimeCallbacks[$event] = [];
  }

  protected function removeEvent($event)
  {
    unset($this->events[$event]);
    unset($this->callbacks[$event]);
    unset($this->onetimeCallbacks[$event]);
  }

  protected function cancel($event, $id)
  {
    unset($this->callbacks[$event][$id]);
    unset($this->onetimeCallbacks[$event][$id]);
    if (
      !sizeof($this->callbacks[$event]) &&
      !sizeof($this->onetimeCallbacks[$event])
    ) {
      $this->removeEvent($event);
    }
  }

  protected function cancelable($event, $id)
  {
    return function () use ($event, $id) {
      $this->cancel($event, $id);
    };
  }

  protected function isset($event)
  {
    return isset($this->events[$event]);
  }
}
