<?php

namespace App\Http\Controllers;

use IRedis;

class AppController extends _Controller
{
  public function home()
  {
    return IRedis::get('test');

    return [
      'msg' => env('APP_NAME') . ' api'
    ];
  }
}
