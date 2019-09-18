<?php

namespace App\Plc;

use App\Models\Plc;

class PlcAccessor
{
  protected $plcs;

  protected $clients;

  public function __construct()
  {
    $this->getPlcData();
    $this->getPlcClients();
  }

  public function clients()
  {
    return $this->clients;
  }

  public function get(int $id): PlcClient
  {
    return $this->clients[$id];
  }

  protected function getPlcData()
  {
    $this->plcs = Plc::all();
  }

  protected function getPlcClients()
  {
    $this->clients = [];

    foreach ($this->plcs as $plc) {
      $this->clients[$plc->id] = new PlcClient($plc->host, $plc->port);
    }
  }
}
