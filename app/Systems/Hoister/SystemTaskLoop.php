<?php

namespace App\Systems\Hoister;

use App\Devices\Plc\Plc;
use Swoole\Coroutine;

class SystemTaskLoop
{
  protected $context;

  protected $state;

  protected $entity;

  public $isStopping = false;

  const FLOOR_DOORS = [
    'door1_auto_address', 'door1_alarm_address', 'door1_block_address',
    'door2_auto_address', 'door2_alarm_address', 'door2_block_address',
  ];

  public function __construct(System $context)
  {
    $this->context = $context;
    $this->state = $context->state;
    $this->entity = $context->entity;
    $this->run();
  }

  public function run()
  {
    go(function () {
      $time = 0;
      $plc = $this->init();
      while (1) {
        $plc->tryOnce(function () use ($plc, $time) {
          $this->readStatus($plc);
          $this->writeHeartbeat($plc, $time);
          $this->readScannerData($plc);
        });

        if ($this->isStopping) {
          $this->isStopping = false;
          break;
        }

        Coroutine::sleep(1);
        $time++;
      }
    });
  }

  protected function init()
  {
    $plc = new Plc(
      $this->entity->plc_host,
      $this->entity->plc_task_port
    );
    $plc->connect();

    return $plc;
  }

  protected function writeHeartbeat(Plc $plc, int $time)
  {
    if ($time % $this->entity->heartbeat_interval !== 0) return;

    $plc->writew($this->entity->heartbeat_address, $time);
  }

  protected function readStatus(Plc $plc)
  {
    $result = [
      'status' => $plc->readw($this->entity->status_address),
      'heartbeat' => $plc->readw($this->entity->heartbeat_address),
      'lift_position' => $plc->readw($this->entity->lift_position_address),
      'floors' => $this->readFloorStatus($plc)
    ];

    $this->state->setData($result);
  }

  protected function readFloorStatus(Plc $plc)
  {
    $values = [];
    foreach ($this->entity->floors as $floor) {
      $states = [];
      foreach (self::FLOOR_DOORS as $key) {
        $address = $floor->$key;
        $states[] = $address === '0' ? null : $plc->readw($address);
      }
      $values[$floor->key] = $states;
    }

    return $values;
  }

  protected function readScannerData(Plc $plc)
  {
    $data = [];

    foreach ($this->entity->scanners as $scanner) {
      $data[$scanner->key] = $plc->readw(
        $scanner->data_address,
        $scanner->data_length
      );
    }

    return $data;
  }
}
