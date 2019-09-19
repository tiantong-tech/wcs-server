<?php

namespace App\System;

interface HoisterSystemContact
{
  public function init();

  public function run();

  public function stop();
}
