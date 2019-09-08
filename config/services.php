<?php

return [
  'qiniu' => [
    'deadline' => env('QINIU_DEADLINE', 3600),
    'secret_key' => env('QINIU_SECRET_KEY'),
    'access_key' => env('QINIU_ACCESS_KEY'),
    'bucket' => env('QINIU_BUCKET'),
  ],
  'gaode' => [
    'web.key' => env('GAODE_WEB_KEY')
  ]
];
