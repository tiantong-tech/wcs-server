<?php

namespace App\Facades;

class Postgres extends _Facade
{
  protected static function getFacadeAccessor()
  {
    return 'App\Services\Postgres';
  }
}
