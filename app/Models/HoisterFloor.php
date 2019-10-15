<?php

namespace App\Models;

use DB;

class HoisterFloor extends _Model
{
  public $table = 'hoister_floors';

  public $primaryKey = 'id';

  protected $fillable = [
    'key', 'floor',
    'door1_auto_address', 'door1_alarm_address', 'door1_block_address',
    'door2_auto_address', 'door2_block_address', 'door2_alarm_address',
  ];

  public function apply($builder)
  {
    $builder->orderBy('key', 'asc');
  }

  public function setHoisterIdAttribute($value)
  {
    $key = HoisterFloor::where('hoister_id', $value)->max('key') + 1;

    $this->attributes['hoister_id'] = $value;
    $this->attributes['key'] = $key;
    $this->attributes['floor'] = $key;
    $key = 3000 + $key * 10;
    $this->attributes['door1_auto_address'] = "D00" . ($key + 1);
    $this->attributes['door1_alarm_address'] = "D00" . ($key + 2);
    $this->attributes['door1_block_address'] = "D00" . ($key + 3);
  }
}
