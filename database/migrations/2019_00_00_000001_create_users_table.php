<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigInteger('id')->primary();
      $table->string('email')->nullable()->unique();
      $table->string('username')->nullable()->unique();
      $table->string('password');
      $table->jsonb('groups')->default('[]');
      $table->string('name')->nullable();
      $table->string('phone_number')->nullable();
      $table->timestamp('created_at')->useCurrent();
    });
  }

  public function down()
  {
    Schema::dropIfExists('users');
  }
}
