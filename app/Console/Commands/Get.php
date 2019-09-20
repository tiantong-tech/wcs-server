<?php

namespace App\Console\Commands;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Models\Hoister;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    go(function () {
      $redis = Redis::getAsyncClient();
      $redis->set('key2', 'swoole redis work');
      var_dump($redis->get('key2'));
    });
    // go(function () {
    //   Redis::subscribe(['test-channel', 'test-channel1'], function ($message) {
    //     echo $message;
    //   });
    // });
    // go(function () {
    //   sleep(100);
    // });
    // echo 100;
  }
}
