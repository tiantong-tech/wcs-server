<?php

namespace App\Plc;

class PlcResponseException extends \Exception
{
  protected $status;

  public function __construct($status)
  {
    $this->status = $status;
  }
}
