<?php

namespace App\Plc;

use Swoole\Client as Cli;

class Client implements  ClientContact
{
  protected $host;

  protected $port;

  protected $protocol;

  protected $client;

  public function __construct(string $host, int $port)
  {
    $this->client = new Cli(SWOOLE_SOCK_TCP);
    $this->host = $host;
    $this->port = $port;
  }

  public function connect()
  {
    try {
      $this->clientConnect();
      $this->test();
      return true;
    } catch (\Exception $e) {
      $this->client->close();
      return false;
    }
  }

  public function reconnect()
  {
    echo "重连中";
    while (1) {
      try {
        echo "...";
        $this->connectOrFail();
        echo "\n连接已恢复\n";
        return;
      } catch (PlcConnectionException $e) {
        sleep(1);
      }
    }
  }

  public function connectOrFail()
  {
    if (!$this->connect()) {
      throw new PlcConnectionException();
    }
  }

  public function test()
  {
    return $this->readwd('2000');
  }

  public function try($callback)
  {
    try {
      $callback($this);
    } catch (PlcException $e) {
      $this->reconnect();
      $this->try($callback);
    }
  }

  public function clientConnect()
  {
    return $this->client->connect($this->host, $this->port, 0.5, 0);
  }

  public function send($message)
  {
    try {
      $this->client->send($message);
      $result = $this->client->recv();
    } catch (\Exception $e) {
      throw new PlcRequestException;
    }

    return $this->decodeMessage($result);
  }

  public function readwd($address, $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $length = $this->decToHex($length, 4);
    $body = '04010000D*' . $address . $length;
    return $this->send($this->generateMessage($body));
  }

  public function writewd($address, int $data, $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $data = $this->decToHex($data, $length * 4);
    $length = $this->decToHex($length, 4);
    $body = '14010000D*' . $address . $length . $data;
    return $this->send($this->generateMessage($body));
  }

  protected function generateMessage($body)
  {
    // 0010 为 CPU监视定时器
    $body = '0010' . $body;
    $length = $this->decToHex(strlen($body), 4);
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
    $status = substr($message, 18, 4);

    if ($status !== '0000') {
      throw new PlcResponseException($status);
    }

    return strlen($message) > 22 ? substr($message, 22) : '';
  }

  protected function decToHex($num, $length)
  {
    return str_pad(strtoupper(dechex($num)), $length, '0', STR_PAD_LEFT);
  }
}
