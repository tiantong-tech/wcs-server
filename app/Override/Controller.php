<?php

namespace App\Override;

use App\Override\Exceptions\HttpException;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	public function viaParams($params, $rules)
	{
		$validator = \Validator::make($params, $rules);

		if ($validator->fails()) {
			throw new \Illuminate\Validation\ValidationException($validator);
		}

		return $params;
	}

	public function via(array $rules, $default = false)
	{
    $params = request(array_keys($rules));
    if ($default !== false) {
      foreach ($rules as $key => $rule) {
        if (!isset($params[$key])) {
          $params[$key] = $default;
        }
      }
    }

    $result = $this->viaParams($params, $rules);
    if ($default !== false) {
      foreach ($result as &$item) {
        if ($item === null) {
          $item = $default;
        }
      }
    }

    return $result;
	}

	public function all()
	{
		return request()->all();
	}

	public function get($name, $rule = 'nullable', $default = null)
	{
    $params = request([$name]);
		$this->viaParams($params, [$name => $rule]);
		$param = isset($params[$name]) ? $params[$name] : $default;

		return $param;
  }

  public function getNullable($name, $rule)
  {
    if (request($name) === '') {
      return null;
    } else {
      $this->get($name, $rule);
    }
  }

	public function success($messages, $status = 201)
	{
		if (!is_array($messages)) {
			$messages = ['msg' => $messages];
		}

		return response()->json($messages, $status);
	}

	public function failure($messages, $status = 400)
	{
		if (!is_array($messages)) {
			$messages = ['msg' => $messages];
		}

		throw new HttpException($messages, $status);
	}
}
