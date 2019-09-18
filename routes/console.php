<?php

use Illuminate\Foundation\Inspiring;
use App\Swoole\TcpServer;
use Illuminate\Support\Facades\Redis;
use App\Plc\PlcAccessor;
use App\System\HoisterSystemAccessor;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('db:rebuild', function () {
	$this->call('migrate:refresh', ['--seed' => 'default']);
})->describe('migrate:refresh && db:seed');

Artisan::command('tcp:serve', function () {
  $server = new TcpServer;
  $server->start();
});

Artisan::command('plc', function () {
  $plc = new Plc('192.168.3.39', 8000);
  $plc->connect();

  function output ($res) {
    echo $res . "\n";
  }

  $plc->writewd('002200', 100000, 2);
});

Artisan::command('get', function (HoisterSystemAccessor $hoisters) {
  return 100;
  // Redis::set('test', 1);
  // Redis::expire('test', 10);

  // while(1) {
  //   echo Redis::get('test');

  //   sleep(1);
  // }
});
