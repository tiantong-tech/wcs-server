<?php

namespace App\Plc;

// 负责通信功能
interface ClientContact
{
  /**
   * 执行 tcp client 连接并测试
   * 连接失败直接关闭
   * @return boolean
   */
  public function connect();

  public function reconnect();

  public function connectOrFail();

  public function try($callback);

  public function send(string $message);

  public function readwd($address);

  public function writewd($address, int $data);
}
