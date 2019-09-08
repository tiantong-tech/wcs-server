<?php

use Illuminate\Foundation\Inspiring;
use App\Swoole\TcpServer;
use App\Services\Plc;

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

Artisan::command('plc:handle', function () {
  $client = new Plc;

  echo $client->read('D2000');
  echo $client->read('D3000');
  echo $client->write('D2000', 1000);
  echo $client->write('D3000', 2000);
});

Artisan::command('plc:watch', function () {
  $plc = new Plc;
  $i = 1;
  while (++$i) {
    echo "round $i \n";

    if ($i % 3 == 0) {
      echo $plc->write('D2001', 2000);

      echo "心跳处理完毕\n";
    }
    if ($i % 1 == 0) {
      echo $plc->read('D3000');

      echo "提升机运行状态正常\n";
    }

    sleep(1);
    echo "\n\n";
  }
});
