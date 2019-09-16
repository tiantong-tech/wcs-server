<?php

namespace App\Plc;

class PlcResponseException extends PlcException
{
  protected $status;

  public function __construct($status)
  {
    $this->status = $status;
  }
}
