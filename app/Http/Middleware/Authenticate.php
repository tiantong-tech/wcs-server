<?php

namespace App\Http\Middleware;

use JWT;
use Auth;
use Closure;

class Authenticate
{
	public function handle($request, Closure $next, ...$groups)
	{
		$token = request()->header('authorization');
		$payload = JWT::decode($tokefn);
		if (!$token || !$payload) {
			return response([
				'msg' => 'fail to authenticate token'
			], 401);
		};

		$user = Auth::findUser($payload['aud']);

		if (!$user) {
			return response([
				'msg' => 'fail to find user by token'
			], 401);
		}

		if (sizeof($groups)) {
			foreach ($user->groups as $group) {
				if (in_array($group, $groups)) {
					return $next($request);
				}
			}

			return $this->failure('fail to validate user groups', 403);
		}

		return $next($request);
	}
}
