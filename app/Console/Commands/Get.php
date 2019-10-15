<?php

namespace App\Console\Commands;

use Swoole\Client;
use App\Laravel\EventBus;

class Get extends _Command
{
  protected $signature = 'get';

  protected $description = 'test command';

  public function handle()
  {
    $client = new Client(SWOOLE_SOCK_TCP);
    $client->connect('localhost', 8302);
    $client->send('你好鸭');
    echo $client->recv();
    $client->send('别走鸭');
    echo $client->recv();

    $client->close();
  }
}
