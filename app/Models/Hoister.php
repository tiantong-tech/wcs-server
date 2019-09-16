<?php

namespace App\Models;

class Hoister extends _Model
{
  protected $table = 'hoisters';

  public function floors()
  {
    return $this->hasMany('hoister_floors', 'hoisters.id', 'hoister_floors.hoister_id');
  }
}
