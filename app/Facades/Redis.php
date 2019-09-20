<?php

namespace App\Facades;

use Swoole\Coroutine\Redis as AsyncRedis;
use Illuminate\Support\Facades\Redis as BaseRedis;

class Redis extends BaseRedis
{
  public static function getAsyncClient($conn = 'default')
  {
    $config = config("database.redis.$conn");
    if (!$config) {
      throw new \Exception;
    }
    $redis = new AsyncRedis;
    $redis->connect($config['host'], $config['port']);
    $redis->select($config['database']);
    $redis->auth($config['password']);

    return $redis;
  }
}
