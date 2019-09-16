<?php

namespace App\System;

interface ManagerContact
{
  public function run();

  public function record();

  public function handle();

  public function status();
}
