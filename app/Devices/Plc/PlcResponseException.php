<?php

namespace App\Devices\Plc;

class PlcResponseException extends PlcException
{
  protected $message;

  public function __construct($status)
  {
    $this->message = "指令错误，错误代码为：$status" . "，详细信息请参考 PLC 手册";
  }
}
