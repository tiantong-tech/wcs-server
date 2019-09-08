<?php

namespace App\Facades;

class Series extends _Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Series';
    }
}
