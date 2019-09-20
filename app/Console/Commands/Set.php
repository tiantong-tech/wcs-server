<?php

namespace App\Console\Commands;

use IRedis as Redis;
use Swoole\Coroutine;
use App\Models\Hoister;
use Swoole\Coroutine\Socket;

class Set extends _Command
{
  protected $signature = 'set';

  protected $description = 'test command';

  public function handle()
  {
    Redis::set('key', 1000);
    // Redis::publish('test-channel', 'stop');
    // Redis::publish('test-channel1', 'stop');
    // go (function () {
    //   $socket = new Socket(AF_INET, SOCK_STREAM);
    //   $socket->connect('localhost', 9503);
    //   $socket->send('test');
    //   echo $socket->recv();
    //   $socket->close();
    // });
  }
}
