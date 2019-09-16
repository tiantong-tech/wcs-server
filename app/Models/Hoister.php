<?php

namespace App\Models;

class Hoister extends _Model
{
  public $table = 'hoisters';

  public $primaryKey = 'id';

  public function floors()
  {
    return $this->hasMany(HoisterFloor::class, 'hoister_id', 'id');
  }
}
