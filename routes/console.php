<?php

use Illuminate\Foundation\Inspiring;
use App\Swoole\TcpServer;
use App\Plc\Client as Plc;
use Illuminate\Support\Facades\Redis;

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
  $plc = new Plc('127.0.0.1', 9502);
  $plc->connect();

  function output ($res) {
    echo $res . "\n";
  }

  output($plc->readwd('2000'));
  output($plc->readwd('002000'));
  output($plc->writewd('2000', '0001'));

});
