<?php

namespace App\Http\Controllers;

use DB;

class PlcController extends _Controller
{
  public function search()
  {
    return DB::table('plc_connections')->get();
  }
}
