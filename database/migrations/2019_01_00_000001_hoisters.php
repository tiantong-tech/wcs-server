<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hoisters extends Migration
{
  public function up()
  {
    Schema::create('hoisters', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name')->default('');

      $table->string('plc_host')->default('192.168.1.1');
      $table->string('plc_task_port')->default('8000');
      $table->string('plc_command_port')->default('8001');

      $table->integer('heartbeat_interval')->default(2);
      $table->string('heartbeat_address')->default('D002500');

      $table->string('bar_code_address')->default('D002901');
      $table->string('bar_code_address_length')->default(2);

      $table->string('status_address')->default('D002000');
      $table->string('dispatch_address')->default('D002501');
      $table->string('running_state_address')->default('D002000');
      $table->string('lift_position_address')->default('D002001');

      $table->boolean('is_configured')->default(false);
      $table->boolean('is_running')->default(false);

      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent();
    });
  }

  public function down()
  {
    Schema::dropIfExists('hoisters');
  }
}
