<?php

namespace App\Http\Controllers;

use Artisan;

class AppController extends _Controller
{
  public function home()
  {
    return $this->success('success to execute artisan command');
  }
}
