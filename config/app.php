<?php

return [
  'name' => env('APP_NAME', 'Laravel'),

  'key' => env('APP_KEY'),
  'cipher' => 'AES-256-CBC',

  'debug' => env('APP_DEBUG'),
  'env' => env('APP_ENV'),

  'url' => env('APP_URL', 'http://localhost'),
  'asset_url' => env('ASSET_URL', null),

  'locale' => 'en',
  'timezone' => env('APP_TIMEZONE', 'Asia/Shanghai'),
  'fallback_locale' => 'en',
  'faker_locale' => 'en_US',

  'providers' => [
    /**
     * @core
     */
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    /**
     * @todo
     */
    Illuminate\View\ViewServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    /**
     * @watching
     */
    Illuminate\Queue\QueueServiceProvider::class,
    /**
     * @package
     */
    Barryvdh\Cors\ServiceProvider::class,
    /**
     * @app
     */
    App\Providers\AppServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
  ],

  'aliases' => [
    /**
     * @Laravel
     */
    'DB' => Illuminate\Support\Facades\DB::class,
    'Log' => Illuminate\Support\Facades\Log::class,
    'Hash' => Illuminate\Support\Facades\Hash::class,
    'Route' => Illuminate\Support\Facades\Route::class,
    'Artisan' => Illuminate\Support\Facades\Artisan::class,
    'Request' => Illuminate\Support\Facades\Request::class,
    'Validator' => Illuminate\Support\Facades\Validator::class,

    /**
     * @Services
     */
    'JWT' => App\Facades\JWT::class,
    'Auth' => App\Facades\Auth::class,
    'Gaode' => App\Facades\Gaode::class,
    'Qiniu' => App\Facades\Qiniu::class,
    'IRedis' => App\Facades\Redis::class,
    'Series' => App\Facades\Series::class,
    'Postgres' => App\Facades\Postgres::class,
    'Transaction' => App\Facades\Transaction::class,
  ],
];
