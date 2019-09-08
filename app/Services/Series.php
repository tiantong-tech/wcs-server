<?php

namespace App\Services;

use DB;
use Carbon\Carbon;

class Series
{
  public function all()
  {
    return DB::table('series')->get();
  }

  public function find(string $name)
  {
    return DB::table('series')->where('name', $name)->first();
  }

  public function create(string $name, int $begin = 0, int $end = 99999999999)
  {
    DB::table('series')->insert([
      'name' => $name,
      'begin' => $begin,
      'end' => $end,
      'value' => $begin
    ]);
  }

  public function delete(string $name)
  {
    DB::table('series')
      ->where('name', $name)
      ->delete();
  }

  public function generate(string $name)
  {
    $sql = 'UPDATE series SET value = value + 1 WHERE name = ? RETURNING "value", "end"';
    $result = DB::select($sql, [$name])[0];
    $end = $result->end;
    $value = $result->value - 1;

    if ($value >= $end) {
      throw new \Exception("Series \"$name\" is overflow, current value is $value, end is $end");
    }

    return $value;
  }

  // 手动调整 value 值
  public function updateValue(string $name, int $value)
  {
    DB::table('series')->where('name', $name)->update([
      'value' => $value
    ]);
  }
}
