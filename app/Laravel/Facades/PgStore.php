<?php

namespace App\Laravel\Facades;

class PgStore extends _Facade
{
	protected static function getFacadeAccessor()
	{
		return 'App\Services\PgStore';
	}
}
