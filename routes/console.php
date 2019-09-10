<?php

use Illuminate\Foundation\Inspiring;
use App\Swoole\TcpServer;
use App\Devices\Plc;

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
  $plc = new Plc(1);

  function output ($res) {
    echo $res . "\n";
  }

  output($plc->read('000010'));
  output($plc->read('002000'));
  output($plc->write('002000', '0101'));
  output($plc->read('002000'));
  output($plc->write('002000', '2222'));
  output($plc->read('002000'));
});
