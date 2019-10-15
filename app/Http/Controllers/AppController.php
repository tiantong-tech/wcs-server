<?php

namespace App\Http\Controllers;

use Artisan;

class AppController extends _Controller
{
  public function home()
  {
    $age = request()->age;

    return $this->success('success to execute artisan command');
  }
}
