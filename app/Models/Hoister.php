<?php

namespace App\Models;

class Hoister extends _Model
{
  public $table = 'hoisters';

  public $primaryKey = 'id';

  public $timestamps = true;

  public $fillable = [
    'name',
    'plc_host', 'plc_task_port', 'plc_command_port',
    'heartbeat_interval', 'heartbeat_address',
    'running_state_address', 'lift_position_address', 'dispatch_address',
    'is_running', 'is_configured',
    'created_at','updated_at',
  ];

  public function floors()
  {
    return $this->hasMany(HoisterFloor::class, 'hoister_id', 'id');
  }

  public function scanners()
  {
    return $this->hasMany(HoisterScanner::class, 'hoister_id', 'id');
  }
}
