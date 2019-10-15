<?php

namespace App\Services;

use DB;

class PgStore
{
  public function set($key, $value)
  {
    $value = json_encode($value, JSON_HEX_APOS);
    DB::statement("INSERT into pgstore values ('$key', '$value') on conflict (key) do update set key = '$key', value = '$value'");
  }

  public function get($key)
  {
    $result = DB::table('pgstore')->where('key', $key)->get()[0]->value;

    return json_decode($result, true);
  }
}
