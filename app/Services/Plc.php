<?php

namespace App\Services;

use Swoole\Client;

class Plc
{
  private $client;

  public function __construct()
  {
    $this->client = new Client(SWOOLE_SOCK_TCP);
    if (!$this->client->connect('127.0.0.1', 9503, -1)) {
      echo 'fail to connect client';
    }

    echo "success to connect plc\n";
  }

  public function read($address)
  {
    $this->client->send('read ' . $address);

    return $this->client->recv();
  }

  public function write($address, $data)
  {
    $this->client->send('write to ' . $address . ' with data ' . $data);

    return $this->client->recv();
  }
}
