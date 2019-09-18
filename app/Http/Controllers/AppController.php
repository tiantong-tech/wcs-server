<?php

namespace App\Http\Controllers;

use Artisan;

class AppController extends _Controller
{
  public function home()
  {
    Artisan::call('get');

    return $this->success('success to excute artisan command');
  }
}
