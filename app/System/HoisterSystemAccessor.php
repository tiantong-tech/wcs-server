<?php

namespace App\System;

use App\Models\Hoister;
use App\Plc\PlcAccessor;

class HoisterSystemAccessor
{
  protected $hoisters;

  public function __construct(PlcAccessor $plc)
  {
    $this->hoisters = [];
    $hoisters = Hoister::with('floors')->get();
    foreach ($hoisters as $hoister) {
      $this->hoisters[] = new HoisterSystem($hoister, $plc->get($hoister->plc_id));
    }
  }

  public function hoisters()
  {
    return $this->hoisters;
  }
}
