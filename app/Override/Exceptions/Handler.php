<?php

namespace App\Override\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
  protected $dontReport = [
    HttpException::class
  ];

	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	public function render($request, Exception $e)
	{
    if (
      $e instanceof NotFoundHttpException ||
      $e instanceof MethodNotAllowedHttpException
    ) {
      return $this->handleNotfound();
    }

		if ($e instanceof ValidationException) {
      return $this->handleValidationException($e);
    }

    if ($e instanceof ThrottleRequestsException) {
      return $this->handleThrottleException();
    }

		return parent::render($request, $e);
  }

  // handlers

  private function handleNotfound()
  {
    return response()->json([
      'msg' => 'route not found',
    ], 404);
  }

  private function handleValidationException($e)
  {
    return response()->json([
      'errors' => $e->errors(),
      'params' => request()->input(),
    ], 422);
  }

  private function handleThrottleException()
  {
    return response()->json([
      'msg' => 'stop for a cup of coffee',
    ], 427);
  }
}
