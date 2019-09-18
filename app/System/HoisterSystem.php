<?php

namespace App\System;

use App\Plc\PlcClient;
use App\Models\Hoister;

class HoisterSystem implements HoisterSystemContact
{
  protected $plc;

  protected $hoister;

  public function __construct(Hoister $hoister, PlcClient $plc)
  {
    $this->plc = $plc;
    $this->hoister = $hoister;
    $plc->connect();
  }

  public function run($time)
  {
    $this->plc->tryOnce(function ($plc) use ($time) {
      $this->readStatus($time);
      $this->writeHeartbeat($time);
    });
  }

  public function readStatus(int $time)
  {
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003000');
    $this->plc->readwd('003003');
  }

  public function writeHeartbeat(int $time)
  {
    if ($time % 2 !== 0) return

    $this->plc->writewd('002200', $time);
  }
}
