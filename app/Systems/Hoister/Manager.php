<?php

namespace App\Systems\Hoister;

use IRedis as Redis;
use App\Models\Hoister;

class Manager
{
  protected $systems = [];

  public function __construct()
  {
    $this->initSystems();
    $this->initSubscriber();
  }

  public function run(int $id)
  {
    if ($this->isset($id)) {
      echo "Hoister $id is already running\n";
      return;
    }
    $entity = $this->getEntity($id);
    if (!$entity) {
      echo "Hoister $id is not found\n";
      return;
    }

    $this->systems[$id] = new System($entity);
    $this->updateRunning($id, true);
    echo "Hoister $id starts running\n";
  }

  public function stop($id)
  {
    $this->remove($id);
    $this->updateRunning($id, false);
  }

  public function remove($id)
  {
    if (!$this->isset($id)) {
      echo "Hoister $id is not running yet\n";
      return;
    }
    $this->systems[$id]->isStopping = true;
    unset($this->systems[$id]);
    echo "Hoister $id has stopped\n";
  }

  //

  protected function initSubscriber()
  {
    Redis::subscribe('system.hoister.accessor', function ($msg) {
      [$method, $id] = explode('.', $msg);
      call_user_func_array([$this, $method], [$id]);
    });
  }

  protected function isset($id)
  {
    return isset($this->systems[$id]);
  }

  protected function initSystems()
  {
    $ids = Hoister::where('is_running', true)
      ->pluck('id');
    foreach ($ids as $id) {
      $this->run($id);
    }
  }

  protected function getEntity($id)
  {
    return Hoister::with('floors')->find($id);
  }

  protected function updateRunning($id, $value)
  {
    Hoister::where('id', $id)->update(['is_running' => $value]);
  }
}
