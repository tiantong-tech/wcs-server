<?php

namespace App\Facades;

class Auth extends _Facade
{
	protected static function getFacadeAccessor()
	{
		return 'App\Services\Auth';
	}
}
