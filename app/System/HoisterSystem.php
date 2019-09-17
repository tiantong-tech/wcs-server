<?php

namespace App\System;

use App\Models\Hoister;
use App\Plc\Client as Plc;

class HoisterSystem implements HoisterContact
{
  protected $plc;

  protected $hoister;
  
  public function __construct(int $id)
  {
    $this->hoister = Hoister::with('floors')->find($id);
    $this->plc = new Plc($this->hoister->plc_id);
  }

  public function record()
  {

  }

  public function writeHeartbeat()
  {

  }
}
