<?php

namespace App\Hoister;

use DB;
use App\Plc\Manager as Plc;

class Client
{
  protected $plc;

  public function __construct($id)
  {
    $hoister = DB::table('hoisters')->where('id', $id)->first();
    if (!$hoister) {
      throw new \Exception('fail to find hoister by id');
    }
    $plc = Plc::find($hoister->plc_id);
  }
}
