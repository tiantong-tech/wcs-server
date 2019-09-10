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
  private $messageHead = "500000FF03FF00";

  public function __construct()
  {
  }

  public function connect()
  {
    $this->client = new Client(SWOOLE_SOCK_TCP);

    if ($this->client->connect('127.0.0.1', 9502, -1)) {
      echo "success to connect plc\n";

      return true;
    } else {
      echo 'fail to connect client';

      return false;
    }
  }

  public function read($address)
  {
    $code = "001004010000D*" . $address . "0001";

    $code = "0018" . $code;
    $message = $this->messageHead . $code;
    $this->client->send($message);
    $result = $this->client->recv();

    return $result;
  }

  public function write($address, $data)
  {
    $code = "001014010000D*" . $address . "0001" . $data;
    $code = "001C" . $code;

    $message = $this->messageHead . $code;

    $this->client->send($message);
    return $this->client->recv();
  }

  public function recordHeartbeat($id)
  {
    if ($this->heartbeat === 10000) {
      $this->heartbeat = 0;
    }

    DB::update("UPDATE plcs set heartbeat = ? where id = ?", [$this->heartbeat++, $id]);
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
