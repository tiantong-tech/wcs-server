<?php

namespace App\Models;

class HoisterScanner extends _Model
{
  public $table = 'hoister_scanners';

  public $primaryKey = 'id';

  protected $fillable = [
    'key', 'data_address', 'data_length',
  ];

  public function apply($builder)
  {
    $builder->orderBy('key', 'asc');
  }
}
