<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->call(SeriesSeeder::class);
		$this->call(UserSeeder::class);

		if (env('APP_ENV') !== 'local') return;
		$this->call(HoisterSeeder::class);
		// 本地测试数据
	}
}
