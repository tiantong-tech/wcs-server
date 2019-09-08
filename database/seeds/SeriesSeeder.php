<?php

use App\Facades\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
	public function run()
	{
		Series::create('root_id', 1000, 1001);
		Series::create('admin_id', 1001, 1999);
    Series::create('sale_id', 10000, 99999);
    Series::create('test_id', 10000000, 99999999);
	}
}
