<?php

namespace App\Services;

use DB;
use Swoole\Client;

class Plc
{
  private $client;
  private $heartbeat = 0;

  /**
   * 5000 副头部
   * 00FF 网络编号
   * FF 控制器编号
   * 03FF 请求目标模块 IO 编号
   * 00 请求目标模块站号
   * 0018 请求数据长度
   * 0010 CPU 监视定时器
   */
  private $messageHead = "500000FF03FF0000180010";

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
    $message = $this->messageHead . "04010000D*" . $address . "00000001";
    $this->client->send("read: $message");
    $result = $this->client->recv();

    return $result;
  }

  public function write($address, $data)
  {
    $message = $this->messageHead . "14010001D*" . $address . "0001" . "$data";

    $this->client->send("write: $message");

    return $this->client->recv();
  }

  public function recordHeartbeat($id)
  {
    if ($this->heartbeat === 10000) {
      $this->heartbeat = 0;
    }

    DB::update("UPDATE plc_connections set heartbeat = ? where id = ?", [$this->heartbeat++, $id]);

    // DB::table('plc_connections')->where('id', $id)->update([
    //   'heartbeat' => $this->heartbeat++
    // ]);
  }

  // private function writeMessageEncode($address)
  // {
  //   $code = "";

  //   return $message;
  // }

  // private function writeDecode($result)
  // {

  // }

  // private function readEncode($address)
  // {

  // }

  // private function readDecode($result)
  // {

  // }
}
