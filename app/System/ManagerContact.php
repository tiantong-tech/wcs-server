<?php

namespace App\System;

interface ManagerContact
{
  public function start();

  public function isAlive(): boolean;
}
