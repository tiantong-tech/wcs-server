<?php

use Illuminate\Foundation\Inspiring;
use App\Swoole\TcpServer;
use App\Plc\Client as Plc;

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
  $plc = new Plc('localhost', '9502');

  function output ($res) {
    echo $res . "\n";
  }

  echo $plc->readcd('2000') . "\n";
  echo $plc->readcd('002000') . "\n";
  echo $plc->writecd('2000', '0001');

});

Artisan::command('get', function() {
  $str = "asdf";

  dd (substr($str, 22) ?? '');
});
