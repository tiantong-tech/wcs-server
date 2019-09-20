<?php

return [
  'default' => 'pgsql',

  'connections' => [
    'pgsql' => [
      'driver' => 'pgsql',
      'host' => env('PG_HOST'),
      'port' => env('PG_PORT'),
      'database' => env('PG_DATABASE'),
      'username' => env('PG_USERNAME'),
      'password' => env('PG_PASSWORD'),
      'charset' => 'utf8',
      'prefix' => '',
      'prefix_indexes' => true,
      'schema' => env('PG_SCHEMA'),
      'sslmode' => 'prefer',
    ],
  ],

  'migrations' => 'migrations',

  'redis' => [
    'client' => 'phpredis',
    'default' => [
      'host' => env('REDIS_HOST'),
      'port' => env('REDIS_PORT'),
      'database' => env('REDIS_DATABASE'),
      'password' => env('REDIS_PASSWORD'),
    ],
  ]
];
