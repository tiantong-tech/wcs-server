<?php

namespace App\System;

interface HoisterContact
{
  public function record();

  public function writeHeartbeat();
}
