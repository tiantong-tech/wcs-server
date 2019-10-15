<?php

namespace App\Laravel\Facades;

class JWT extends _Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\JWT';
    }
}
