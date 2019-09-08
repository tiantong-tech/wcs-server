<?php

namespace Tests\Unit;

use Series;
use Tests\TestCase;

class SeriesServiceTest extends TestCase
{
  public function testAll()
  {
    $series = Series::all()->toArray();
    $this->assertTrue(is_array($series));
  }

  public function testCreate()
  {
    $name = 'test';
    Series::create($name, 1000000, 9999999);
    $this->assertNotNull(Series::find($name));

    return $name;
  }

  /**
   * @depends testCreate
   */
  public function testGenerate($name)
  {
    $id = Series::generate($name);
    $this->assertTrue(true);
  }

  /**
   * @depends testCreate
   */
  public function testDelete($name)
  {
    Series::delete($name);
    $this->assertNull(Series::find($name));
  }
}
