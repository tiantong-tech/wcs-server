<?php

namespace App\Plc;

// 负责通信功能
interface ClientContact
{
  public function connect();

  public function connectOrFail();

  public function reconnect();

  public function try(\Closure $callback);

  public function tryOnce(\Closure $callback);

  public function send(string $message);

  public function readwd(string $address);

  public function writewd(string $address, int $data);
}
