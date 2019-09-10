<?php

use App\Facades\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
	public function run()
	{
		Series::create('root_id', 1000, 1001);
	}
}
