<?php

namespace App\Laravel\Facades;

use Swoole\Coroutine\Redis as AsyncRedis;
use Illuminate\Support\Facades\Redis as BaseRedis;

class Redis extends BaseRedis
{
  public static function getAsyncClient($conn = 'default')
  {
    $config = config("database.redis.$conn");
    if (!$config) {
      throw new \Exception("redis config $conn is not found");
    }
    $redis = new AsyncRedis;
    $redis->connect($config['host'], $config['port']);
    $redis->select($config['database']);
    $redis->auth($config['password']);

    return $redis;
  }

  public static function subscribe($chans, $callback, $conn = 'default')
  {
    if (!is_array($chans)) {
      $chans = [$chans];
    }

    go(function () use ($conn, $chans, $callback) {
      $redis = self::getAsyncClient($conn);
      $redis->subscribe($chans);
      $msg = $redis->recv(); // wtf
      while ($msg = $redis->recv()) {
        $message = array_pop($msg);
        $callback($message);
      }
    });
  }
}
