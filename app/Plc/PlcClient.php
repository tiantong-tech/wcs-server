<?php

namespace App\Plc;

use Swoole\Client;

class PlcClient implements  PlcClientContact
{
  protected $host;

  protected $port;

  protected $protocol;

  protected $tcpClient;

  protected $isTcpClientConnected;

  public function __construct(string $host = '', string $port = '')
  {
    $this->tcpClient = new Client(SWOOLE_SOCK_TCP);
    if ($host) {
      $this->host = $host;
      $this->port = $port;
    }
  }

  /**
   * 1. 建立 Tcp Client 连接
   * 2. 执行 PLC test
   *
   * @return Boolean
   */
  public function connect($host = null, $port = null)
  {
    if ($this->isTcpClientConnected) {
      $this->tcpClient->close();
    }

    if ($host) {
      $this->host = $host;
      $this->port = $port;
    }

    try {
      $this->tcpClient->connect($this->host, $this->port, 0.5, 0);
      $this->isTcpClientConnected = true;
    } catch (\Exception $e) {
      $this->isTcpClientConnected = false;

      return false;
    }

    try {
      $this->test();

      return true;
    } catch (PlcConnectionException $e) {
      return false;
    }
  }

  public function reconnect()
  {
    while (1) {
      try {
        $this->connectOrFail();
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

  public function try($callback)
  {
    try {
      $callback($this);
    } catch (PlcException $e) {
      $this->reconnect();
      $this->try($callback);
    }
  }

  public function tryOnce(\Closure $callback)
  {
    try {
      $callback($this);
    } catch (PlcException $e) {
      if ($this->connect()) {
        $callback($this);
      } else {

      }
    }
  }

  public function send($message)
  {
    $result = '';
    try {
      $this->tcpClient->send($message);
      $result = $this->tcpClient->recv();
    } catch (\Exception $e) {
      throw new PlcRequestException;
    }

    return $this->decodeMessage($result);
  }

  /**
   * 后续考虑增加 getReadMessage 和 getWriteMessage
   */
  public function readw(string $address, int $length = 1)
  {
    $body = '04010000' .
      $this->handleAddress($address) .
      $this->handleLength($length);

    return $this->send($this->generateMessage($body));
  }

  public function writew(string $address, int $data, int $length = 1)
  {
    $body = '14010000' .
      $this->handleAddress($address) .
      $this->handleData($data, $length) .
      $this->handleLength($length);

    return $this->send($this->generateMessage($body));
  }

  /**
   * sub methods
   */
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

  public function test()
  {
    try {
      $this->readw('002000');
    } catch (PlcException $e) {
      throw new PlcConnectionException;
    }
  }

  protected function handleAddress(string &$address): string
  {
    $prefix = $address[0];
    if (is_numeric($prefix)) {
      $prefix = "D";
    } else {
      $address = substr($address, 1);
    }

    return $address = $prefix . '*' . str_pad($address, 6, '0', STR_PAD_LEFT);
  }

  protected function handleData(string &$data, int $length): string
  {
    $data = $this->decToHex($data, $length * 4);
    $this->swapDec($data);

    return $data;
  }

  protected function handleLength(int $len): string
  {
    return $this->decToHex($len, 4);
  }

  // 将 01110010 转化为 00100111
  protected function swapDec(string &$data)
  {
    $len = strlen($data);
    $l = $len / 8;
    for ($i = 0; $i < $l; $i++) {
      for ($j = 0; $j < 4; $j++) {
        $m = $i * 4 + $j;
        $n = $len - ($i + 1) * 4 + $j;

        $t = $data[$m];
        $data[$m] = $data[$n];
        $data[$n] = $t;
      }
    }
  }

  protected function decToHex(int $num, int $length)
  {
    return str_pad(strtoupper(dechex($num)), $length, '0', STR_PAD_LEFT);
  }
}
