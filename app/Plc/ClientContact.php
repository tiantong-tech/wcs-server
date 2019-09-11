<?php

namespace App\Plc;

interface ClientContact
{
  /**
   * 1. 执行 tcp client 连接，连接失败直接 close
   * @return boolean
   */
  public function connect();

  public function reconnect();

  public function connectOrFail();

  public function try($callback);

  public function send(string $message);

  public function creadD($address);

  public function cwriteD($address, int $data);
}
