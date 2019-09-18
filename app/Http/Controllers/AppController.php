<?php

namespace App\Http\Controllers;

use Artisan;

class AppController extends _Controller
{
  public function home()
  {
    Artisan::call('system:run');

    return $this->success('success to excute artisan command');
  }
}
