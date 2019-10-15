<?php

namespace Tests\Unit;

use JWT;
use Tests\TestCase;

class JwtServiceTest extends TestCase
{
  protected $payload = [
    'aud' => 1,
    'sub' => 1
  ];

  public function testEncode()
  {
    $token = JWT::encode($this->payload);
    $this->assertNotNull($token);

    return $token;
  }

  /**
   * @depends testEncode
   */
  public function testDecode($token)
  {
    $payload = JWT::decode($token);
    JWT::isNeedToRefresh();
    JWT::refresh();
    foreach ($this->payload as $key => $value) {
      if ($payload[$key] !== $value) {
        $this->assertTrue(false);
      }
    }
    $this->assertTrue(true);

    return $payload;
  }
}
