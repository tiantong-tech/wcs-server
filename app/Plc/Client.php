<?php

namespace App\Plc;

use Swoole\Client as Cli;

class Client
{
  protected $host;

  protected $port;

  protected $protocol;

  protected $client;

  public function __construct($host, $port)
  {
    $client = new Cli(SWOOLE_SOCK_TCP);
    if (!$client->connect($host, $port)) {
      throw new PlcUnreachableException;
    }

    $this->host = $host;
    $this->port = $port;
    $this->client = $client;
  }

  public function send($message)
  {
    $this->client->send($message);

    $result = $this->client->recv();
    // return $this->decodeMessage($result);

    return $result;
  }

  public function recv()
  {
    $message = $this->client->recv();
  }

  public function readcd($address, $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $length = $this->transLength($length);
    $body = '04010000D*' . $address . $length;
    return $this->send($this->generateMessage($body));
  }

  public function writecd($address, $data, $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $length = $this->transLength($length);
    $body = '14010000D*' . $address . $length . $data;
    return $this->send($this->generateMessage($body));
  }

  public function generateMessage($body)
  {
    // 0010 为 CPU监视定时器
    $body = '0010' . $body;
    $length = $this->transLength(strlen($body));
    /**
     * @prefix 500000FF03FF00
     * 5000 副头部
     * 00FF 网络编号
     * FF 控制器编号
     * 03FF 请求目标模块 IO 编号
     * 00 请求目标模块站号
     * 0018 请求数据长度
     * 0010 CPU 监视定时器
     */
    $message = '500000FF03FF00' . $length . $body;
    // $this->client->send($message);

    return $message;
  }

  protected function decodeMessage($message)
  {
    $status = substr($message, 19, 4);
    if ($status !== '0000') {
      throw new PlcResponseException;
    }

    return strlen($message) > 22 ? substr($message, 22) : '';
  }

  public function transLength($length)
  {
    return str_pad(strtoupper(dechex($length)), 4, '0', STR_PAD_LEFT);
  }
}
