<?php

namespace App\Override\Exceptions;

class HttpException extends \Exception
{
	public $response;

	public function __construct($messages, $status = 400)
	{
		if (!is_array($messages)) {
			$messages = ['msg' => $messages];
		}

		$this->response = response()->json($messages, $status);
  }

  public function render()
  {
    return $this->response;
  }
}
