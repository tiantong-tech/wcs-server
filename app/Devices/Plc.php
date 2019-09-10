<?php

namespace App\Devices;

use DB;
use Swoole\Client;
use App\Exceptions\PlcNotFoundException;

class Plc
{
  private $plc;

  private $client;

  public function __construct($id)
  {
    $plc = DB::table('plcs')->where('id', $id)->first();
    if (!$plc) {
      throw new PlcNotFoundException('plc data is not found');
    }
    $this->plc = $plc;
    $client = new Client(SWOOLE_SOCK_TCP);

    if (!$client->connect($plc->host, $plc->port, -1)) {
      throw new \Exception('plc server is not accessable');
    };

    $this->client = $client;
  }

  public function read($addr)
  {
    $this->client->send($addr);
    return $this->client->recv();
  }

  public function write($addr, $data)
  {
    $this->client->send($addr . $data);
    return $this->client->recv();
  }
}
