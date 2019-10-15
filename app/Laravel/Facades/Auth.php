<?php

namespace App\Laravel\Facades;

class Auth extends _Facade
{
	protected static function getFacadeAccessor()
	{
		return 'App\Services\Auth';
	}
}
