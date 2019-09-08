<?php

namespace Tests\Feature;

use JWT;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class BaseTest extends TestCase
{
  protected function withToken($token)
  {
    return $this->withHeader('Authorization', $token);
  }

  protected function withRoot()
  {
    return $this->withHeader('Authorization', JWT::encode(['aud' => 1000]));
  }
}
