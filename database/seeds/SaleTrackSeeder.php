<?php

use App\Services\Enums;
use App\Models\SaleTrack;
use Illuminate\Database\Seeder;

class SaleTrackSeeder extends Seeder
{
	public function run()
	{
    $data = [];
    for ($i = 0; $i < 100; $i++) {
      $item = [];
      $item['type'] = Enums::saleTrackTypes[0];
      $item['name'] = "客户名称_$i";
      $item['email'] = "test_customer_$i@sale.com";
      $item['message'] = "测试消息_$i";
      $item['company'] = "测试公司_$i";
      $item['project_name'] = "测试项目_$i";
      $item['phone_number'] = "1888888888$i";
      $data[] = $item;
    }

    SaleTrack::insert($data);
	}
}
