<?php

namespace App\Plc;

use Swoole\Client as Cli;

class Client implements  ClientContact
{
  protected $host;

  protected $port;

  protected $protocol;

  protected $client;

  /**
   * tcp 连接是否建立
   */
  protected $isConnected = false;

  protected $autoconnect = true;

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
      } catch (\Exception $e) {
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
    return $this->creadD('2000');
  }

  public function try($callback)
  {
    try {
      $callback();
    } catch (\Exception $e) {
      
    }
  }

  public function clientConnect()
  {
    return $this->client->connect($this->host, $this->port, 0.5, 0);
  }

  public function send($message)
  {
    $this->client->send($message);
    $result = $this->client->recv();
    return $this->decodeMessage($result);
  }

  public function creadD($address, $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $length = $this->transLength($length);
    $body = '04010000D*' . $address . $length;
    return $this->send($this->generateMessage($body));
  }

  public function cwriteD($address, int $data, $length = 1)
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
    $status = substr($message, 18, 4);

    if ($status !== '0000') {
      throw new PlcResponseException($status);
    }

    return strlen($message) > 22 ? substr($message, 22) : '';
  }

  public function transLength($length)
  {
    return str_pad(strtoupper(dechex($length)), 4, '0', STR_PAD_LEFT);
  }
}
