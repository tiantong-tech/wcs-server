<?php

use App\Tcp\PlcServer;
use Illuminate\Foundation\Inspiring;

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

Artisan::command('plc:serve', function () {
  $server = new PlcServer;
  $server->start();
})->describe('mock a plc device');
