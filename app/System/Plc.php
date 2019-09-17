<?php

namespace App\System;

use App\Plc\Client;

class Plc
{
  protected $plcs = [];

  public function __construct()
  {
    $plcs = DB::table('plcs')->get();
    foreach ($plcs as $plc) {

    }
  }

  public function getPlcs()
  {

  }
}
