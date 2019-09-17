<?php

namespace App\Plc;

use Swoole\Client as Cli;

class Client implements  ClientContact
{
  protected $host;

  protected $port;

  protected $protocol;

  protected $tcpClient;

  protected $isTcpClientConnected;

  public function __construct(string $host, int $port)
  {
    $this->tcpClient = new Cli(SWOOLE_SOCK_TCP);
    $this->host = $host;
    $this->port = $port;
  }

  /**
   * 1. 建立 Tcp Client 连接
   * 2. 执行 PLC test
   *
   * @return Boolean
   */
  public function connect()
  {
    if ($this->isTcpClientConnected) {
      $this->tcpClient->close();
    }

    try {
      $this->tcpClient->connect($this->host, $this->port, 0.5, 0);
      $this->isTcpClientConnected = true;
    } catch (\Exception $e) {
      $this->isTcpClientConnected = false;
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
      echo "正在尝试重连...\n";
      if ($this->connect()) {
        echo "已连接\n";
        $callback($this);
      } else {
        echo "重连失败\n";
      }
    }
  }

  /**
   * @depend 连接成功后 read 必定成功
   */
  public function test()
  {
    try {
      $this->readwd('002000');
    } catch (PlcException $e) {
      throw new PlcConnectionException;
    }
  }

  public function send($message)
  {
    $result = '';
    try {
      $this->tcpClient->send($message);
      $result = $this->tcpClient->recv();
    } catch (\Exception $e) {
      echo "指令传送失败\n";
      echo "指令：$message\n";
      echo "响应：$result\n";

      throw new PlcRequestException;
    }

    return $this->decodeMessage($result);
  }

  public function readwd(string $address, int $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $length = $this->decToHex($length, 4);
    $body = '04010000D*' . $address . $length;

    return $this->send($this->generateMessage($body));
  }

  public function writewd(string $address, int $data, int $length = 1)
  {
    $address = str_pad($address, 6, '0', STR_PAD_LEFT);
    $data = $this->decToHex($data, $length * 4);
    $this->swapDec($data);
    $length = $this->decToHex($length, 4);
    $body = '14010000D*' . $address . $length . $data;
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
      echo "响应异常，代码为：$status\n";
      throw new PlcResponseException($status);
    }

    return strlen($message) > 22 ? substr($message, 22) : '';
  }

  protected function decToHex($num, $length)
  {
    return str_pad(strtoupper(dechex($num)), $length, '0', STR_PAD_LEFT);
  }

  protected function swapDec(&$num)
  {
    $len = strlen($num);
    $l = $len / 8;
    for ($i = 0; $i < $l; $i++) {
      for ($j = 0; $j < 4; $j++) {
        $m = $i * 4 + $j;
        $n = $len - ($i + 1) * 4 + $j;

        $t = $num[$m];
        $num[$m] = $num[$n];
        $num[$n] = $t;
      }
    }
  }
}
