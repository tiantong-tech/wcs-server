<?php

namespace App\Http\Controllers;

class AppController extends _Controller
{
  public function home()
  {
    return [
      'msg' => env('APP_NAME') . ' api'
    ];
  }
}
