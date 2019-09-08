<?php

namespace App\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT as JWTBase;

class JWT
{
	protected $key;

	protected $alg;

	protected $payload = [];

	public function __construct()
	{
		$this->alg = config('jwt.alg');
		$this->key = config('jwt.key');
	}

	public function encode(array $payload = [])
	{
		$payload['iat'] = Carbon::now()->timestamp;
		$payload['exp'] = Carbon::now()->addDay(config('jwt.ttl'))->timestamp;
		$payload['rfa'] = Carbon::now()->addDay(config('jwt.rft'))->timestamp;

		return 'Bearer ' . JWTBase::encode($payload, $this->key);
	}

	public function decode($token)
	{
		try {
			$payload = (array) JWTBASE::decode(substr($token, 7), $this->key, [$this->alg]);

			return $this->payload = $payload;
		} catch (\Exception $e) {
			return null;
		}
	}

	public function payload()
	{
		return $this->payload;
	}

	// 断言 token 已成功解析
	public function refresh()
	{
		return $this->encode($this->payload);
	}

	public function isNeedToRefresh()
	{
		$now = Carbon::now()->timestamp;
		$exp = $this->payload['exp'];

		return $exp < $now;
	}
}
