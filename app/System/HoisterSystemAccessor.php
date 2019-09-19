<?php

namespace App\System;

use App\Models\Hoister;

class HoisterSystemAccessor
{
  protected $hoisters;

  public function __construct()
  {
    $this->hoisters = [];
    $ids = Hoister::pluck('id');
    foreach ($ids as $id) {
      $this->hoisters[] = new HoisterSystem($id);
    }
  }

  public function hoisters()
  {
    return $this->hoisters;
  }
}
