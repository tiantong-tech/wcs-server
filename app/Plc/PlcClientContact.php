<?php

namespace App\Plc;

interface PlcClientContact
{
  public function connect();

  public function connectOrFail();

  public function reconnect();

  public function try(\Closure $callback);

  public function tryOnce(\Closure $callback);

  public function send(string $message);

  public function readw(string $address);

  public function writew(string $address, int $data);
}
