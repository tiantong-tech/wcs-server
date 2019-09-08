<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->call(SeriesSeeder::class);
		$this->call(UserSeeder::class);

		if (env('APP_ENV') !== 'local') return;

		// 本地测试数据
    $this->call(SaleTrackSeeder::class);
    $this->call(SaleProjectSeeder::class);
	}
}
