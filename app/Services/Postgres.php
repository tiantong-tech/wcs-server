<?php

namespace App\Services;

class Postgres
{
  /**
   * handle decode postgres array type
   */
  public static function getArray($data, $type = 'int')
  {
    return json_decode('['.substr($data, 1, -1).']', true);
  }

  /**
   * handle encode postgres array type
   */
  public static function setArray($data, $type = 'int')
  {
    return '{'.implode(',', $data).'}';
  }
}
