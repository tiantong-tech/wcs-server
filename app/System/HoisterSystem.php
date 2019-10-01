<?php

namespace App\System;

use IRedis as Redis;
use App\Plc\PlcClient;
use Swoole\Coroutine;
use App\Models\Hoister;

class HoisterSystem
{
  protected $id;

  protected $plc;

  protected $hoister;

  protected $isRunning = false;

  protected $commands = [];

  const FLOOR_DOORS = [
    'door1_auto_address', 'door1_alarm_address', 'door1_block_address',
    'door2_auto_address', 'door2_alarm_address', 'door2_block_address',
  ];

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->init();
    $this->run();
    $this->subscribeCommands();
  }

  public function init()
  {
    $this->hoister = Hoister::with('floors')
      ->where('id', $this->id)
      ->first();
  }

  public function run()
  {
    if ($this->isRunning) return;

    go(function () {
      $time = 0;
      $this->isRunning = true;
      $plc = new PlcClient(
        $this->hoister->plc_host,
        $this->hoister->plc_task_port
      );
      $plc->connect();

      while (1) {
        if ($this->id === 1) {
          echo "round $time\n";
        }
        $plc->tryOnce(function () use ($plc, $time) {
          $this->readStatus($plc);
          $this->writeHeartbeat($plc, $time);
        });

        // handle stop
        if (!$this->isRunning) {
          echo "系统停止运行\n";
          break;
        }

        Coroutine::sleep(1);
        $time++;
      }
    });
  }

  public function subscribeCommands()
  {
    Redis::subscribe($this->getRedisKey() . ":commands", function ($msg) {
      switch ($msg) {
        case 'run':
          $this->run();
          break;
        case 'stop':
          $this->stop();
          break;
        default:
          $this->commands[] = $msg;
      }
    });
  }

  public function handleCommands()
  {
    while ($command = array_shift($this->commands)) {
      var_dump($command);
    }
  }

  public function stop()
  {
    $this->isRunning = false;
  }

  public function getRedisKey()
  {
    return "system.hoister.$this->id";
  }

  private function writeHeartbeat($plc, int $time)
  {
    if ($time % $this->hoister->heartbeat_interval !== 0) return;

    $plc->writew($this->hoister->heartbeat_address, $time);
  }

  private function readStatus($plc)
  {
    $result = json_encode([
      'heartbeat' => $plc->readw($this->hoister->heartbeat_address),
      'lift_position' => $plc->readw($this->hoister->lift_position_address),
      'floors' => $this->readFloorStatus($plc)
    ]);

    $key = $this->getRedisKey() . ".state";
    Redis::publish($key, $result);
  }

  private function readFloorStatus($plc)
  {
    $values = [];
    foreach ($this->hoister->floors as $floor) {
      $states = [];
      foreach (self::FLOOR_DOORS as $key) {
        $address = $floor->$key;
        $states[] = $address === '0' ? null : $plc->readw($address);
      }
      $values[$floor->key] = $states;
    }

    return $values;
  }
}
