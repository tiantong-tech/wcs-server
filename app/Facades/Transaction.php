<?php

namespace App\Facades;

class Transaction extends _Facade
{
	protected static function getFacadeAccessor()
	{
		return 'App\Services\Transaction';
	}
}
