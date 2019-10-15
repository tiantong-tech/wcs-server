<?php

namespace Tests\Unit;

use PgStore;
use Tests\TestCase;

class PgStoreTest extends TestCase
{
  public function testSetDelete()
  {
    $key = '___just_for_test___';
    $value = "_\"_test_value_\'";
    PgStore::set($key, $value);
    $result = PgStore::get($key);

    $this->assertTrue($value === $result);
  }
}
