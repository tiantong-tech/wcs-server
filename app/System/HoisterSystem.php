<?php

namespace App\System;

use IRedis as Redis;
use App\Plc\PlcClient;
use Swoole\Coroutine;
use App\Models\Hoister;

class HoisterSystem implements HoisterSystemContact
{
  protected $id;

  protected $plc;

  protected $hoister;

  protected $isRunning = false;

  protected $isStopping = false;

  public function __construct(int $id)
  {
    $this->id = $id;
    // $this->initSubscribe();
  }

  public function init()
  {
    $this->hoister = Hoister::with('floors')
      ->where('id', $this->id)
      ->first();
    $this->plc = new PlcClient(
      $this->hoister->plc_host,
      $this->hoister->plc_port
    );
  }

  public function initSubscribe()
  {
    $channel = "system:hoister:$this->id:command";

    Redis::subscribe($channel, function ($command) {
      if (!$this->isRunning) return;

      switch ($command) {
        case 'stop': return $this->stop();
      }
    });
  }

  public function run()
  {
    go(function () {
      $this->plc->connect();
      $time = 0;
      while (1) {
        echo "hoister" . $this->hoister->id . ": round $time\n";
        $this->plc->tryOnce(function () use ($time) {
          $this->readStatus();
          $this->writeHeartbeat($time);
        });
        $this->handleCommand();
        // handle stop
        if ($this->isStopping) {
          // echo "系统已停止\n";
          $this->isStopping = false;
          break;
        }

        Coroutine::sleep(1);
        $time++;
      }
    });
  }

  public function handleCommand()
  {

  }

  public function stop()
  {
    $this->isStopping = true;
  }

  private function writeHeartbeat(int $time)
  {
    if ($time % $this->hoister->heartbeat_interval !== 0) return;

    $this->plc->writewd('002200', $time);
  }

  private function readStatus()
  {
    $result = json_encode([
      'heartbeat' => $this->plc->readwd($this->hoister->heartbeat_address),
      'lift_position' => $this->plc->readwd($this->hoister->lift_position_address),
      'floors' => $this->readFloorStatus()
    ]);

    $key = "system:hoister:$this->id:states";
    Redis::set($key, $result);
  }

  private function readFloorStatus()
  {
    $values = [];

    foreach ($this->hoister->floors as $floor) {
      $values[$floor->key] = [];
      $values[$floor->key][0] = [
        $this->plc->readwd($floor->gate1_auto_address),
        $this->plc->readwd($floor->gate1_auto_address),
        $this->plc->readwd($floor->gate1_auto_address)
      ];
      if (!$floor->gate2_auto_address) continue;
      $values[$floor->key][1] = [
        $this->plc->readwd($floor->gate2_auto_address),
        $this->plc->readwd($floor->gate2_auto_address),
        $this->plc->readwd($floor->gate2_auto_address)
      ];
    }

    return $values;
  }
}
