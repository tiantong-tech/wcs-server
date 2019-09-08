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
    $this->assertArraySubset($this->payload, $payload);

    return $payload;
  }
}
