<?php

namespace App\Services;

class Accessor
{
  static $instance;

  // self 并不能提供类型提示 :(
  static function access(...$params): self
  {
    if (isset(self::$instance)) {
      return self::$instance;
    } else {
      $class = static::class;

      return self::$instance = new $class(...$params);
    }
  }
}
