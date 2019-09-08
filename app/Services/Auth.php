<?php

namespace App\Services;

use JWT;
use Hash;
use App\Models\User;

class Auth
{
  protected $user;

  public function findUser($id)
  {
    return $this->user = User::find($id);
  }

  public function user()
  {
    return $this->user;
  }

  public function id()
  {
    return $this->user->id;
  }

  public function matchPassword($password, $where)
  {
    $user = User::where($where)
      ->select(['id', 'password'])
      ->first();

    if ($user && Hash::check($password, $user->password)) {
      return JWT::encode(['aud' => $user->id]);
    } else {
      return '';
    }
  }
}
