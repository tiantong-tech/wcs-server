<?php

namespace App\System;

interface ManagerContact
{
  public function run();

  public function isAlive(): boolean;

  public function keepalive();
}
