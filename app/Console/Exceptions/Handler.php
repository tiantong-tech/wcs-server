<?php

namespace App\Exceptions;

use Exception;
use Transaction;
use App\Laravel\Exceptions\Handler as _Handler;

class Handler extends _Handler
{
	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	public function render($request, Exception $e)
	{
		if (Transaction::working()) {
			Transaction::rollback();
    }

		return parent::render($request, $e);
	}
}
