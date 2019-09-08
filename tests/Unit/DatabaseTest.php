<?php

namespace Tests\Unit;

use DB;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
  public function testConnect()
  {
    $this->assertNotNull(DB::select('select 100'));
  }
}
