<?php

namespace App\Plc;

use App\Models\Plc;

class Accessor
{
  protected $plcs;

  protected $clients;

  public function __construct()
  {
    $this->getPlcData();
    $this->getPlcClients();
  }

  protected function getPlcData()
  {
    $this->plcs = Plc::all();
  }

  protected function getClients()
  {
    $this->clients = [];

    foreach ($this->plcs as $plc) {
      $this->clients[$plc->id] = new Client($plc->host, $plc->port);
    }
  }
}
