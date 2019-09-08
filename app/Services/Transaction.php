<?php

namespace App\Services;

use DB;

class Transaction
{
	protected $working = false;

	public function begin()
	{
		if ($this->working) return;

		DB::beginTransaction();
		$this->working = true;
	}

	public function commit()
	{
		DB::commit();
		$this->working = false;
	}

	public function rollback()
	{
		DB::rollback();
		$this->working = false;
	}

	public function working()
	{
		return $this->working;
	}
}
